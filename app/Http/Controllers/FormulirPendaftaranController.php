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
        $activeWave = GelombangPendaftaran::whereDate('tanggal_mulai', '<=', now())
            ->withCount('formulirs')
            ->get()
            ->filter(function ($wave) {
                return $wave->limit_siswa > $wave->formulirs_count;
            })
            ->sortBy('tanggal_mulai')
            ->first();

        // Jika tidak ada yang aktif, ambil yang terakhir (untuk display estimasi)
        if (!$activeWave) {
            $activeWave = GelombangPendaftaran::latest()->first();
        }

        return view('formulir.index', compact('formulir', 'gelombangs', 'jurusan', 'activeWave', 'sudahBayar', 'revisiMenunggu'));
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
        $activeWave = GelombangPendaftaran::whereDate('tanggal_mulai', '<=', now())
            ->withCount('formulirs')
            ->get()
            ->filter(function ($wave) {
                return $wave->limit_siswa > $wave->formulirs_count;
            })
            ->sortBy('tanggal_mulai')
            ->first();

        if ($activeWave) {
            $validated['gelombang_id'] = $activeWave->id;
        } else {
            // Jika tidak ada gelombang aktif/tersedia, buat baru
            $lastWave = GelombangPendaftaran::latest()->first();

            // Tentukan nama gelombang baru
            $newWaveName = 'Gelombang 1';
            $newPrice = 1000000; // Default price

            if ($lastWave) {
                // Coba ambil angka dari nama gelombang terakhir
                if (preg_match('/(\d+)$/', $lastWave->nama_gelombang, $matches)) {
                    $nextNum = intval($matches[1]) + 1;
                    $newWaveName = 'Gelombang ' . $nextNum;
                } else {
                    $newWaveName = $lastWave->nama_gelombang . ' (Lanjutan)';
                }
                $newPrice = $lastWave->harga;
            }

            $newWave = GelombangPendaftaran::create([
                'nama_gelombang' => $newWaveName,
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addMonth(), // Default 1 bulan
                'limit_siswa' => 250, // Default kapasitas baru
                'harga' => $newPrice,
                'catatan' => 'Gelombang otomatis dibuat oleh sistem karena slot sebelumnya penuh.'
            ]);

            $validated['gelombang_id'] = $newWave->id;
        }



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
