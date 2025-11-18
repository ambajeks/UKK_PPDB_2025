<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use App\Models\Promo;
use App\Models\Pembayaran;
use App\Models\FormulirPendaftaran;
use App\Models\GelombangPendaftaran;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // CARD STATISTICS
        $total_users = User::count();
        $total_jurusan = Jurusan::count();
        $total_gelombang = GelombangPendaftaran::count();
        $total_pendaftar = FormulirPendaftaran::count();
        $promo_aktif = Promo::where('is_aktif', 1)->count();
        $total_pembayaran = Pembayaran::sum('jumlah_akhir'); // sesuai database kamu

        // TABEL PENDAFTAR BARU
        $pendaftar_baru = FormulirPendaftaran::with('user', 'jurusan')
            ->latest()
            ->take(5)
            ->get();

        // GRUPKAN PENDAFTAR PER TANGGAL (GRAFIK)
        $grafik_pendaftar = FormulirPendaftaran::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'ASC')
        ->get();

        // GRAFIK PEMBAYARAN PER BULAN
        $grafik_income = Pembayaran::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('SUM(jumlah_akhir) as total')
        )
        ->groupBy('bulan')
        ->orderBy('bulan', 'ASC')
        ->get();

        return view('admin.dashboard', compact(
            'total_users',
            'total_jurusan',
            'total_gelombang',
            'total_pendaftar',
            'promo_aktif',
            'total_pembayaran',
            'pendaftar_baru',
            'grafik_pendaftar',
            'grafik_income'
        ));
    }
}
