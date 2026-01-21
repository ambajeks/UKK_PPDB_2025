<?php

namespace App\Http\Controllers;

use App\Models\FormulirPendaftaran;
use App\Models\GelombangPendaftaran;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormulirPendaftaranController extends Controller
{
    /**
     * Menampilkan form pendaftaran
     */
    public function index()
    {

        $formulir = FormulirPendaftaran::where('user_id', auth()->id())->first();

        $gelombangs = GelombangPendaftaran::all();
        $jurusan = Jurusan::all();

        // Cek status pembayaran - jika sudah ada pembayaran (Lunas/Pending/menunggu_verifikasi), form terkunci
        $sudahBayar = false;
        if ($formulir) {
            $pembayaran = \App\Models\Pembayaran::where('formulir_id', $formulir->id)
                ->whereIn('status', ['Lunas', 'Pending', 'menunggu_verifikasi'])
                ->first();
            $sudahBayar = (bool) $pembayaran;
        }

        // Ambil revisi yang menunggu jika ada
        $revisiMenunggu = null;
        if ($formulir) {
            $revisiMenunggu = $formulir->getRevisiMenunggu();
        }

        // Logika Penentuan Gelombang Otomatis (untuk display)
        // Patokan 1: Waktu (tanggal_mulai <= sekarang AND tanggal_selesai >= sekarang)
        // Patokan 2: Limit (limit_siswa > jumlah pendaftar)
        $activeWave = GelombangPendaftaran::whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_selesai', '>=', now())
            ->withCount('formulirs')
            ->get()
            ->filter(function ($wave) {
                return $wave->limit_siswa > $wave->formulirs_count;
            })
            ->sortBy('tanggal_mulai')
            ->first();

        // Flag untuk menampilkan pesan jika tidak ada gelombang yang tersedia
        $noWaveAvailable = !$activeWave;
        $noWaveReason = null;
        
        if ($noWaveAvailable) {
            // Cek alasan: apakah karena waktu atau karena limit
            $expiredWave = GelombangPendaftaran::whereDate('tanggal_selesai', '<', now())
                ->latest('tanggal_selesai')
                ->first();
            
            $fullWave = GelombangPendaftaran::whereDate('tanggal_mulai', '<=', now())
                ->whereDate('tanggal_selesai', '>=', now())
                ->withCount('formulirs')
                ->get()
                ->filter(function ($wave) {
                    return $wave->limit_siswa <= $wave->formulirs_count;
                })
                ->first();
            
            $futureWave = GelombangPendaftaran::whereDate('tanggal_mulai', '>', now())
                ->orderBy('tanggal_mulai')
                ->first();
            
            if ($fullWave) {
                $noWaveReason = 'Gelombang saat ini sudah mencapai batas kuota. Silakan tunggu gelombang berikutnya.';
                if ($futureWave) {
                    $noWaveReason .= ' Gelombang berikutnya: ' . $futureWave->nama_gelombang . ' (mulai ' . $futureWave->tanggal_mulai . ')';
                }
            } elseif ($expiredWave && !$futureWave) {
                $noWaveReason = 'Periode pendaftaran untuk semua gelombang sudah berakhir.';
            } elseif ($futureWave) {
                $noWaveReason = 'Belum ada gelombang yang dibuka. Gelombang berikutnya: ' . $futureWave->nama_gelombang . ' (mulai ' . $futureWave->tanggal_mulai . ')';
            } else {
                $noWaveReason = 'Tidak ada gelombang pendaftaran yang tersedia saat ini. Silakan hubungi admin.';
            }
        }

        return view('formulir.index', compact('formulir', 'gelombangs', 'jurusan', 'activeWave', 'sudahBayar', 'revisiMenunggu', 'noWaveAvailable', 'noWaveReason'));
    }

    /**
     * Menyimpan data formulir pendaftaran
     */
    public function store(Request $request)
    {
        // Cek apakah user sudah bayar - jika sudah, tidak boleh update formulir
        if ($request->formulir_id) {
            $formulir = FormulirPendaftaran::where('user_id', auth()->id())
                ->where('id', $request->formulir_id)
                ->first();

            if ($formulir) {
                $pembayaran = \App\Models\Pembayaran::where('formulir_id', $formulir->id)
                    ->whereIn('status', ['Lunas', 'Pending', 'menunggu_verifikasi'])
                    ->first();

                if ($pembayaran) {
                    return redirect()->back()
                        ->with('error', 'Formulir tidak dapat diubah karena Anda sudah melakukan pembayaran.')
                        ->withInput();
                }
            }
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nisn' => 'nullable|string|max:20|unique:formulir_pendaftaran,nisn,' . ($request->formulir_id ?? ''),
            'asal_sekolah' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'nik' => 'nullable|string|max:20|unique:formulir_pendaftaran,nik,' . ($request->formulir_id ?? ''),
            'anak_ke' => 'nullable|integer|min:1',
            'jenis_kelamin' => 'required|string|max:100',
            'alamat' => 'required|string',
            'desa' => 'required|string|max:50',
            'kelurahan' => 'required|string|max:50',
            'kecamatan' => 'required|string|max:50',
            'kota' => 'required|string|max:50',
            'jurusan_id' => 'required',
            'no_hp' => 'required|string|max:20',
            // 'gelombang_id' => 'required|exists:gelombang_pendaftaran,id' // Dihapus karena otomatis
        ]);

        // Logika Penentuan Gelombang Otomatis
        // Patokan 1: Waktu (tanggal_mulai <= sekarang AND tanggal_selesai >= sekarang)
        // Patokan 2: Limit (limit_siswa > jumlah pendaftar)
        $activeWave = GelombangPendaftaran::whereDate('tanggal_mulai', '<=', now())
            ->whereDate('tanggal_selesai', '>=', now())
            ->withCount('formulirs')
            ->get()
            ->filter(function ($wave) {
                return $wave->limit_siswa > $wave->formulirs_count;
            })
            ->sortBy('tanggal_mulai')
            ->first();

        if (!$activeWave) {
            // Cek alasan mengapa tidak ada gelombang
            $fullWave = GelombangPendaftaran::whereDate('tanggal_mulai', '<=', now())
                ->whereDate('tanggal_selesai', '>=', now())
                ->withCount('formulirs')
                ->get()
                ->filter(function ($wave) {
                    return $wave->limit_siswa <= $wave->formulirs_count;
                })
                ->first();
            
            $futureWave = GelombangPendaftaran::whereDate('tanggal_mulai', '>', now())
                ->orderBy('tanggal_mulai')
                ->first();
            
            if ($fullWave) {
                $errorMsg = 'Pendaftaran tidak dapat dilakukan. Gelombang saat ini sudah mencapai batas kuota.';
                if ($futureWave) {
                    $errorMsg .= ' Gelombang berikutnya: ' . $futureWave->nama_gelombang . ' (mulai ' . $futureWave->tanggal_mulai . ')';
                }
            } elseif ($futureWave) {
                $errorMsg = 'Belum ada gelombang yang dibuka. Gelombang berikutnya: ' . $futureWave->nama_gelombang . ' (mulai ' . $futureWave->tanggal_mulai . ')';
            } else {
                $errorMsg = 'Tidak ada gelombang pendaftaran yang tersedia saat ini. Silakan hubungi admin.';
            }
            
            return redirect()->back()
                ->with('error', $errorMsg)
                ->withInput();
        }

        $validated['gelombang_id'] = $activeWave->id;



        try {
            if ($request->formulir_id) {
                // dd('masuk update');
                // Update existing formulir
                $formulir = FormulirPendaftaran::where('user_id', auth()->id())
                    ->where('id', $request->formulir_id)
                    ->firstOrFail();

                $formulir->update($validated);

                $message = 'Formulir berhasil diperbarui!';
            } else {
                // dd('masuk create');
                // Create new formulir
                $validated['user_id'] = auth()->id();
                $validated['nomor_pendaftaran'] = $this->generateNomorPendaftaran();

                FormulirPendaftaran::create($validated);

                $message = 'Formulir berhasil disimpan!';
            }

            return redirect()->route('formulir.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Generate nomor pendaftaran otomatis
     */
    private function generateNomorPendaftaran()
    {
        $tahun = date('Y');
        $bulan = date('m');
        $lastFormulir = FormulirPendaftaran::latest()->first();

        $sequence = $lastFormulir ? intval(substr($lastFormulir->nomor_pendaftaran, -4)) + 1 : 1;

        return 'PPDB' . $tahun . $bulan . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Menampilkan data formulir (jika perlu)
     */
    public function show($id)
    {
        $formulir = FormulirPendaftaran::where('user_id', auth()->id())
            ->findOrFail($id);

        return view('formulir.show', compact('formulir'));
    }
}
