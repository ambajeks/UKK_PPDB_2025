<?php

namespace App\Http\Controllers;

use App\Models\FormulirPendaftaran;
use App\Models\OrangTua;
use App\Models\Wali;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataKeluargaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $formulir = auth()->user()->formulir()->first();
        
        if (!$formulir) {
            return redirect()->route('formulir.index')
                ->with('error', 'Anda harus mengisi formulir pendaftaran terlebih dahulu.');
        }

        try {
            // Inisialisasi variabel dengan nilai default
            $ayah = null;
            $ibu = null;
            $wali = null;

            // Coba ambil data ayah
            try {
                $ayah = OrangTua::where('formulir_id', $formulir->id)
                    ->where('jenis_orangtua', 'ayah')
                    ->first();
            } catch (\Exception $e) {
                \Log::warning('Error loading ayah data: ' . $e->getMessage());
                $ayah = null;
            }

            // Coba ambil data ibu
            try {
                $ibu = OrangTua::where('formulir_id', $formulir->id)
                    ->where('jenis_orangtua', 'ibu')
                    ->first();
            } catch (\Exception $e) {
                \Log::warning('Error loading ibu data: ' . $e->getMessage());
                $ibu = null;
            }

            // Coba ambil data wali
            try {
                $wali = Wali::where('formulir_id', $formulir->id)->first();
            } catch (\Exception $e) {
                \Log::warning('Error loading wali data: ' . $e->getMessage());
                $wali = null;
            }

            return view('data-keluarga.index', compact('formulir', 'ayah', 'ibu', 'wali'));

        } catch (\Exception $e) {
            \Log::error('Error loading data keluarga: ' . $e->getMessage());
            
            // Return dengan nilai default
            return view('data-keluarga.index', [
                'formulir' => $formulir,
                'ayah' => null,
                'ibu' => null,
                'wali' => null
            ])->with('error', 'Terjadi kesalahan saat memuat data. Silakan coba lagi.');
        }
    }

    public function storeOrangTua(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'formulir_id' => 'required|exists:formulir_pendaftaran,id',
            'jenis_orangtua' => 'required|in:ayah,ibu',
            'nama_ayah' => 'nullable|string|max:100',
            'tanggal_lahir_ayah' => 'nullable|date',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'penghasilan_ayah' => 'nullable|numeric',
            'alamat_ayah' => 'nullable|string',
            'no_hp_ayah' => 'nullable|string|max:20',
            'nik_ayah' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:100',
            'tanggal_lahir_ibu' => 'nullable|date',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'penghasilan_ibu' => 'nullable|numeric',
            'alamat_ibu' => 'nullable|string',
            'no_hp_ibu' => 'nullable|string|max:20',
            'nik_ibu' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi. Silakan periksa data Anda.');
        }

        try {
            $formulir = FormulirPendaftaran::find($request->formulir_id);
            
            if ($formulir->user_id !== auth()->id()) {
                abort(403);
            }

            // Siapkan data untuk disimpan
            $data = $request->all();
            
            // Update or create data orang tua berdasarkan jenis
            OrangTua::updateOrCreate(
                [
                    'formulir_id' => $request->formulir_id,
                    'jenis_orangtua' => $request->jenis_orangtua
                ],
                $data
            );

            $jenis = $request->jenis_orangtua == 'ayah' ? 'Ayah' : 'Ibu';
            return redirect()->route('data-keluarga.index')
                ->with('success', "Data $jenis berhasil disimpan!");

        } catch (\Exception $e) {
            \Log::error('Error storing orang tua: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function storeWali(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'formulir_id' => 'required|exists:formulir_pendaftaran,id',
            'nama_wali' => 'nullable|string|max:100',
            'alamat_wali' => 'nullable|string',
            'no_hp_wali' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi.');
        }

        try {
            $formulir = FormulirPendaftaran::find($request->formulir_id);
            
            if ($formulir->user_id !== auth()->id()) {
                abort(403);
            }

            // Update or create data wali
            Wali::updateOrCreate(
                ['formulir_id' => $request->formulir_id],
                $request->except(['_token', 'formulir_id'])
            );

            return redirect()->route('data-keluarga.index')
                ->with('success', 'Data wali berhasil disimpan!');

        } catch (\Exception $e) {
            \Log::error('Error storing wali: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}