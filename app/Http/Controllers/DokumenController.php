<?php

namespace App\Http\Controllers;

use App\Models\DokumenPendaftaran;
use App\Models\FormulirPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DokumenController extends Controller
{
    public function index()
    {
        $formulir = auth()->user()->formulir()->first();
        return view('dokumen.index', compact('formulir'));
    }

    public function store(Request $request)
    {
        // return response()->json(['message' => 'This is a placeholder response.']);      
        $validator = Validator::make($request->all(), [
            'formulir_id' => 'required|exists:formulir_pendaftaran,id',
            'jenis_dokumen' => 'required|in:kartu_keluarga,akta_kelahiran,foto_3x4,surat_keterangan_lulus,ijazah_sd,ktp_orang_tua',
            'file' => 'required|file|max:2048'
        ], [
            'file.max' => 'Ukuran file maksimal 2MB',
            'file.required' => 'File harus diupload'
        ]);

        $jenis = $request->jenis_dokumen;
        $allowedTypes = $this->getAllowedTypes($jenis);
        $validator->after(function ($validator) use ($request, $allowedTypes) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $extension = strtolower($file->getClientOriginalExtension());

                if (!in_array($extension, $allowedTypes)) {
                    $allowedTypesText = implode(', ', array_map('strtoupper', $allowedTypes));
                    $validator->errors()->add('file', "Format file tidak diizinkan. Format yang diizinkan: $allowedTypesText");
                }
            }
        });

        if ($validator->fails()) {
            // Jika request AJAX, return JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $file = $request->file('file');
            $formulir = FormulirPendaftaran::find($request->formulir_id);

            if ($formulir->user_id !== auth()->id()) {
                abort(403);
            }

            // Hapus dokumen lama jika ada
            DokumenPendaftaran::where('formulir_id', $request->formulir_id)
                ->where('jenis_dokumen', $request->jenis_dokumen)
                ->delete();

            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = 'dokumen_' . $request->jenis_dokumen . '_' . time() . '.' . $extension;
            $path = $file->storeAs('dokumen', $fileName, 'public');

            // Simpan ke database
            $dokumen = DokumenPendaftaran::create([
                'formulir_id' => $request->formulir_id,
                'jenis_dokumen' => $request->jenis_dokumen,
                'nama_file' => $fileName,
                'path_file' => $path,
                'original_name' => $originalName,
                'extension' => $extension,
                'size' => $file->getSize() / 1024,
                'mime_type' => $file->getMimeType()
            ]);

            // Jika request AJAX, return JSON response
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Dokumen berhasil diupload!',
                    'dokumen' => [
                        'id' => $dokumen->id,
                        'original_name' => $dokumen->original_name,
                        'file_size' => $dokumen->size < 1024 ?
                            number_format($dokumen->size, 0) . ' KB' :
                            number_format($dokumen->size / 1024, 1) . ' MB',
                        'is_image' => in_array(strtolower($dokumen->extension), ['jpg', 'jpeg', 'png', 'gif']),
                        'file_url' => Storage::url($dokumen->path_file),
                        'download_url' => route('dokumen.download', $dokumen->id),
                        'delete_url' => route('dokumen.destroy', $dokumen->id)
                    ]
                ]);
            }

            return redirect()->route('dokumen.index')
                ->with('success', 'Dokumen berhasil diupload!');

        } catch (\Exception $e) {
            // Jika request AJAX, return JSON error
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        $dokumen = DokumenPendaftaran::findOrFail($id);

        if ($dokumen->formulir->user_id !== auth()->id()) {
            abort(403);
        }

        return Storage::disk('public')->download($dokumen->path_file, $dokumen->original_name);
    }

    public function destroy($id, Request $request)
    {
        $dokumen = DokumenPendaftaran::findOrFail($id);

        if ($dokumen->formulir->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            $jenisDokumen = $dokumen->jenis_dokumen;

            // Hapus file
            $possiblePaths = [
                storage_path('app/public/' . $dokumen->path_file),
                public_path('storage/' . $dokumen->path_file),
            ];

            $deletedFromStorage = false;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    unlink($path);
                    $deletedFromStorage = true;
                    break;
                }
            }

            if (!$deletedFromStorage && Storage::disk('public')->exists($dokumen->path_file)) {
                Storage::disk('public')->delete($dokumen->path_file);
                $deletedFromStorage = true;
            }

            // Hapus dari database
            $dokumen->delete();

            // Jika request AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Dokumen berhasil dihapus!',
                    'jenis_dokumen' => $jenisDokumen
                ]);
            }

            return redirect()->route('dokumen.index')
                ->with('success', 'Dokumen berhasil dihapus!');

        } catch (\Exception $e) {
            \Log::error('Error menghapus dokumen: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function getAllowedTypes($jenisDokumen)
    {
        $types = [
            'kartu_keluarga' => ['pdf', 'jpg', 'jpeg'],
            'akta_kelahiran' => ['pdf', 'jpg', 'jpeg'],
            'foto_3x4' => ['jpg', 'jpeg', 'png'],
            'surat_keterangan_lulus' => ['pdf'],
            'ijazah_sd' => ['pdf'],
            'ktp_orang_tua' => ['pdf']
        ];

        return $types[$jenisDokumen] ?? ['pdf', 'jpg', 'jpeg', 'png'];
    }
}