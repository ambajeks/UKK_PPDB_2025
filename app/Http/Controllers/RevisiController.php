<?php

namespace App\Http\Controllers;

use App\Models\FormulirPendaftaran;
use App\Models\RevisiPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevisiController extends Controller
{
    /**
     * Tampilkan form revisi
     */
    public function show()
    {
        $formulir = FormulirPendaftaran::where('user_id', auth()->id())->firstOrFail();

        // Ambil revisi yang paling baru dan status menunggu
        $revisi = $formulir->getRevisiMenunggu();

        if (!$revisi) {
            return redirect()->route('status.index')
                ->with('error', 'Tidak ada revisi yang perlu dikerjakan.');
        }

        return view('revisi.form', compact('formulir', 'revisi'));
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

        if (in_array('nama_lengkap', $revisi->field_revisi)) {
            $rules['nama_lengkap'] = 'required|string|max:100';
        }
        if (in_array('nisn', $revisi->field_revisi)) {
            $rules['nisn'] = 'nullable|string|max:20';
        }
        if (in_array('jenis_kelamin', $revisi->field_revisi)) {
            $rules['jenis_kelamin'] = 'required|string|max:100';
        }
        if (in_array('tempat_lahir', $revisi->field_revisi)) {
            $rules['tempat_lahir'] = 'required|string|max:50';
        }
        if (in_array('tanggal_lahir', $revisi->field_revisi)) {
            $rules['tanggal_lahir'] = 'required|date';
        }
        if (in_array('asal_sekolah', $revisi->field_revisi)) {
            $rules['asal_sekolah'] = 'required|string|max:100';
        }
        if (in_array('agama', $revisi->field_revisi)) {
            $rules['agama'] = 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu';
        }
        if (in_array('nik', $revisi->field_revisi)) {
            $rules['nik'] = 'nullable|string|max:20';
        }
        if (in_array('anak_ke', $revisi->field_revisi)) {
            $rules['anak_ke'] = 'nullable|integer|min:1';
        }
        if (in_array('alamat', $revisi->field_revisi)) {
            $rules['alamat'] = 'required|string';
        }
        if (in_array('desa', $revisi->field_revisi)) {
            $rules['desa'] = 'required|string|max:50';
        }
        if (in_array('kelurahan', $revisi->field_revisi)) {
            $rules['kelurahan'] = 'required|string|max:50';
        }
        if (in_array('kecamatan', $revisi->field_revisi)) {
            $rules['kecamatan'] = 'required|string|max:50';
        }
        if (in_array('kota', $revisi->field_revisi)) {
            $rules['kota'] = 'required|string|max:50';
        }
        if (in_array('no_hp', $revisi->field_revisi)) {
            $rules['no_hp'] = 'required|string|max:20';
        }
        if (in_array('dokumen', $revisi->field_revisi)) {
            $rules['dokumen_upload'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($formulir, $revisi, $validated, $request) {
            // Update hanya field yang ada di validated
            $updateData = [];
            foreach ($validated as $key => $value) {
                if ($key !== 'dokumen_upload' && $value !== null) {
                    $updateData[$key] = $value;
                }
            }

            if (!empty($updateData)) {
                $formulir->update($updateData);
            }

            // Handle dokumen upload jika ada
            if ($request->hasFile('dokumen_upload')) {
                $files = $request->file('dokumen_upload');
                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $file) {
                    $path = $file->store('dokumen_revisi', 'public');

                    // Simpan ke dokumen_pendaftaran atau update yang lama
                    // Bisa disesuaikan dengan kebutuhan bisnis
                }
            }

            // Update status revisi menjadi selesai
            $revisi->update([
                'status_revisi' => 'selesai',
                'selesai_at' => now()
            ]);
        });

        return redirect()->route('status.index')
            ->with('success', 'Revisi berhasil disimpan! Silakan menunggu verifikasi admin.');
    }
}
