<?php

namespace App\Http\Controllers;

use App\Models\FormulirPendaftaran;
use App\Models\DokumenPendaftaran;
use App\Models\RevisiPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RevisiController extends Controller
{
    /**
     * Tampilkan halaman index revisi (menu revisi)
     */
    public function index()
    {
        $formulir = FormulirPendaftaran::where('user_id', auth()->id())->first();

        if (!$formulir) {
            return redirect()->route('dashboard')
                ->with('info', 'Anda belum memiliki formulir pendaftaran.');
        }

        // Ambil semua revisi untuk formulir ini
        $revisiMenunggu = $formulir->revisi()->where('status_revisi', 'menunggu')->latest()->first();
        $riwayatRevisi = $formulir->revisi()->where('status_revisi', 'selesai')->latest()->get();

        return view('revisi.index', compact('formulir', 'revisiMenunggu', 'riwayatRevisi'));
    }

    /**
     * Tampilkan form revisi
     */
    public function show()
    {
        $formulir = FormulirPendaftaran::where('user_id', auth()->id())->firstOrFail();

        // Ambil revisi yang paling baru dan status menunggu
        $revisi = $formulir->getRevisiMenunggu();

        if (!$revisi) {
            return redirect()->route('revisi.index')
                ->with('error', 'Tidak ada revisi yang perlu dikerjakan.');
        }

        // Load dokumen yang sudah ada
        $dokumenAda = $formulir->dokumen->keyBy('jenis_dokumen');

        return view('revisi.form', compact('formulir', 'revisi', 'dokumenAda'));
    }

    /**
     * Simpan revisi pendaftaran
     */
    public function store(Request $request)
    {
        $formulir = FormulirPendaftaran::where('user_id', auth()->id())
            ->findOrFail($request->formulir_id);

        $revisi = RevisiPendaftaran::findOrFail($request->revisi_id);

        // Validasi data sesuai field yang perlu direvisi
        $rules = [];
        $fieldRevisi = $revisi->field_revisi ?? [];
        $dokumenRevisi = $revisi->dokumen_revisi ?? [];

        // Validasi field data
        if (in_array('nama_lengkap', $fieldRevisi)) {
            $rules['nama_lengkap'] = 'required|string|max:100';
        }
        if (in_array('nisn', $fieldRevisi)) {
            $rules['nisn'] = 'nullable|string|max:20';
        }
        if (in_array('jenis_kelamin', $fieldRevisi)) {
            $rules['jenis_kelamin'] = 'required|string|max:100';
        }
        if (in_array('tempat_lahir', $fieldRevisi)) {
            $rules['tempat_lahir'] = 'required|string|max:50';
        }
        if (in_array('tanggal_lahir', $fieldRevisi)) {
            $rules['tanggal_lahir'] = 'required|date';
        }
        if (in_array('asal_sekolah', $fieldRevisi)) {
            $rules['asal_sekolah'] = 'required|string|max:100';
        }
        if (in_array('agama', $fieldRevisi)) {
            $rules['agama'] = 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu';
        }
        if (in_array('nik', $fieldRevisi)) {
            $rules['nik'] = 'nullable|string|max:20';
        }
        if (in_array('anak_ke', $fieldRevisi)) {
            $rules['anak_ke'] = 'nullable|integer|min:1';
        }
        if (in_array('alamat', $fieldRevisi)) {
            $rules['alamat'] = 'required|string';
        }
        if (in_array('desa', $fieldRevisi)) {
            $rules['desa'] = 'required|string|max:50';
        }
        if (in_array('kelurahan', $fieldRevisi)) {
            $rules['kelurahan'] = 'required|string|max:50';
        }
        if (in_array('kecamatan', $fieldRevisi)) {
            $rules['kecamatan'] = 'required|string|max:50';
        }
        if (in_array('kota', $fieldRevisi)) {
            $rules['kota'] = 'required|string|max:50';
        }
        if (in_array('no_hp', $fieldRevisi)) {
            $rules['no_hp'] = 'required|string|max:20';
        }

        // Validasi upload dokumen
        foreach ($dokumenRevisi as $jenisDokumen) {
            $rules["dokumen_{$jenisDokumen}"] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($formulir, $revisi, $validated, $request, $dokumenRevisi) {
            // Update field data
            $updateData = [];
            foreach ($validated as $key => $value) {
                // Skip dokumen uploads
                if (!str_starts_with($key, 'dokumen_') && $value !== null) {
                    $updateData[$key] = $value;
                }
            }

            if (!empty($updateData)) {
                $formulir->update($updateData);
            }

            // Handle dokumen uploads
            foreach ($dokumenRevisi as $jenisDokumen) {
                $inputName = "dokumen_{$jenisDokumen}";

                if ($request->hasFile($inputName)) {
                    $file = $request->file($inputName);

                    // Cari dokumen lama
                    $dokumenLama = DokumenPendaftaran::where('formulir_id', $formulir->id)
                        ->where('jenis_dokumen', $jenisDokumen)
                        ->first();

                    // Hapus file lama dari storage jika ada
                    if ($dokumenLama && $dokumenLama->path_file) {
                        Storage::disk('public')->delete($dokumenLama->path_file);
                    }

                    // Upload file baru
                    $path = $file->store('dokumen/' . $formulir->id, 'public');
                    $extension = $file->getClientOriginalExtension();
                    $originalName = $file->getClientOriginalName();
                    $size = round($file->getSize() / 1024, 2); // KB
                    $mimeType = $file->getMimeType();

                    if ($dokumenLama) {
                        // Update record yang ada
                        $dokumenLama->update([
                            'nama_file' => pathinfo($path, PATHINFO_BASENAME),
                            'path_file' => $path,
                            'original_name' => $originalName,
                            'extension' => $extension,
                            'size' => $size,
                            'mime_type' => $mimeType
                        ]);
                    } else {
                        // Buat record baru
                        DokumenPendaftaran::create([
                            'formulir_id' => $formulir->id,
                            'jenis_dokumen' => $jenisDokumen,
                            'nama_file' => pathinfo($path, PATHINFO_BASENAME),
                            'path_file' => $path,
                            'original_name' => $originalName,
                            'extension' => $extension,
                            'size' => $size,
                            'mime_type' => $mimeType
                        ]);
                    }
                }
            }

            // Update status revisi menjadi selesai
            $revisi->update([
                'status_revisi' => 'selesai',
                'selesai_at' => now()
            ]);
        });

        return redirect()->route('revisi.index')
            ->with('success', 'Revisi berhasil disimpan! Silakan menunggu verifikasi admin.');
    }
}
