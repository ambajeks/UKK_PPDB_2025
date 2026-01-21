<?php

namespace App\Http\Controllers;

use App\Models\FormulirPendaftaran;
use Illuminate\Http\Request;

class SeragamController extends Controller
{
    /**
     * Menampilkan daftar siswa yang sudah diverifikasi tapi belum ambil seragam
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = FormulirPendaftaran::with(['user', 'jurusan', 'kelas', 'gelombang'])
            ->where('status_verifikasi', 'diverifikasi')
            ->where('status_pengambilan_seragam', 'belum');

        // Filter berdasarkan search keyword
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nomor_pendaftaran', 'like', "%{$search}%")
                  ->orWhereHas('kelas', function ($subQ) use ($search) {
                      $subQ->where('nama_kelas', 'like', "%{$search}%");
                  })
                  ->orWhereHas('jurusan', function ($subQ) use ($search) {
                      $subQ->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        $calonSiswa = $query->latest('verified_at')->get();

        return view('admin.seragam.index', compact('calonSiswa', 'search'));
    }

    /**
     * Menandai siswa sudah mengambil seragam
     */
    public function ambil($id)
    {
        $calonSiswa = FormulirPendaftaran::findOrFail($id);

        // Pastikan siswa sudah terverifikasi
        if (!$calonSiswa->isTerverifikasi()) {
            return redirect()->route('admin.seragam.index')
                ->with('error', 'Siswa belum terverifikasi.');
        }

        // Update status pengambilan seragam
        $calonSiswa->update([
            'status_pengambilan_seragam' => 'sudah',
            'tanggal_pengambilan_seragam' => now(),
            'admin_pengambilan_id' => auth()->id(),
        ]);

        return redirect()->route('admin.seragam.index')
            ->with('success', 'Pengambilan seragam untuk ' . $calonSiswa->nama_lengkap . ' berhasil dicatat!');
    }

    /**
     * Menampilkan riwayat pengambilan seragam
     */
    public function riwayat(Request $request)
    {
        $search = $request->input('search');
        
        $query = FormulirPendaftaran::with(['user', 'jurusan', 'kelas', 'gelombang', 'adminPengambilan'])
            ->where('status_verifikasi', 'diverifikasi')
            ->where('status_pengambilan_seragam', 'sudah');

        // Filter berdasarkan search keyword
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nomor_pendaftaran', 'like', "%{$search}%")
                  ->orWhereHas('kelas', function ($subQ) use ($search) {
                      $subQ->where('nama_kelas', 'like', "%{$search}%");
                  })
                  ->orWhereHas('jurusan', function ($subQ) use ($search) {
                      $subQ->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('adminPengambilan', function ($subQ) use ($search) {
                      $subQ->where('username', 'like', "%{$search}%");
                  });
            });
        }

        $calonSiswa = $query->latest('tanggal_pengambilan_seragam')->get();

        return view('admin.seragam.riwayat', compact('calonSiswa', 'search'));
    }
}
