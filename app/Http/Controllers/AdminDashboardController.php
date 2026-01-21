<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use App\Models\Promo;
use App\Models\Pembayaran;
use App\Models\FormulirPendaftaran;
use App\Models\GelombangPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPendaftaranExport;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // STATISTIK DASAR
        $total_pendaftar = FormulirPendaftaran::where('status_verifikasi', 'diverifikasi')->count();
        // $menunggu_verifikasi = FormulirPendaftaran::where('status_verifikasi', 'menunggu')->count();
        // buatkan query yang menghitung jumlah total formulir pendaftaran yang statusnya menunggu verifikasi yang dimana data formulir ini juga ada pada table pembayaran dengan cara join table formulir_pendaftaran dan pembayaran berdasarkan formulir_id kemudian hitung jumlah data yang status_verifikasi nya menunggu verifikasi
        $menunggu_verifikasi = FormulirPendaftaran::where('status_verifikasi', 'menunggu')
            ->whereIn('id', function ($query) {
                $query->select('formulir_id')
                    ->from('pembayaran');
            })
            ->count();
        
        $total_penerimaan = Pembayaran::where('status', 'Lunas')->sum('jumlah_akhir');
        $pembayaran_lunas = Pembayaran::where('status', 'Lunas')->count();
        $total_jurusan = Jurusan::count();
        $total_gelombang = GelombangPendaftaran::count();
        $promo_aktif = Promo::where('is_aktif', 1)->count();

        // GELOMBANG TERPOPULER
        $gelombangPopuler = GelombangPendaftaran::withCount([
            'formulirs' => function ($query) {
                $query->where('status_verifikasi', 'diverifikasi');
            }
        ])
            ->orderBy('formulirs_count', 'desc')
            ->take(5)
            ->get();

        // TABEL PENDAFTAR BARU dengan filter search
        $search = $request->input('search');
        
        $queryPendaftar = FormulirPendaftaran::with(['user', 'jurusan', 'kelas', 'gelombang', 'pembayaran.promo'])
            ->where('status_verifikasi', 'diverifikasi');

        // Filter berdasarkan search keyword
        if ($search) {
            $searchLower = strtolower(trim($search));
            
            if ($searchLower === 'promo') {
                // Filter siswa yang menggunakan promo
                $queryPendaftar->whereHas('pembayaran', function ($q) {
                    $q->whereNotNull('promo_voucher_id');
                });
            } elseif ($searchLower === 'normal') {
                // Filter siswa yang tidak menggunakan promo
                $queryPendaftar->whereHas('pembayaran', function ($q) {
                    $q->whereNull('promo_voucher_id');
                });
            } else {
                // Filter berdasarkan field lainnya
                $queryPendaftar->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('nomor_pendaftaran', 'like', "%{$search}%")
                      ->orWhere('created_at', 'like', "%{$search}%")
                      ->orWhereHas('gelombang', function ($subQ) use ($search) {
                          $subQ->where('nama_gelombang', 'like', "%{$search}%");
                      })
                      ->orWhereHas('jurusan', function ($subQ) use ($search) {
                          $subQ->where('nama', 'like', "%{$search}%");
                      })
                      ->orWhereHas('pembayaran', function ($subQ) use ($search) {
                          $subQ->where('kode_transaksi', 'like', "%{$search}%");
                      })
                      ->orWhereHas('kelas', function ($subQ) use ($search) {
                          $subQ->where('nama_kelas', 'like', "%{$search}%");
                      });
                });
            }
        }

        // Jika ada search, tampilkan semua hasil. Jika tidak, batasi 5
        if ($search) {
            $pendaftar_baru = $queryPendaftar->latest()->get();
        } else {
            $pendaftar_baru = $queryPendaftar->latest()->take(5)->get();
        }

        // SLOT GELOMBANG
        $gelombangInfo = [];
        $totalSlotTersisa = 0;
        $gelombangs = GelombangPendaftaran::all();

        foreach ($gelombangs as $gelombang) {
            $terisi = FormulirPendaftaran::where('gelombang_id', $gelombang->id)->count();
            $tersisa = max(0, $gelombang->limit_siswa - $terisi);
            $totalSlotTersisa += $tersisa;

            $gelombangInfo[] = [
                'nama' => $gelombang->nama_gelombang,
                'terisi' => $terisi,
                'tersisa' => $tersisa,
                'kapasitas' => $gelombang->limit_siswa,
                'persentase' => $gelombang->limit_siswa > 0 ? round(($terisi / $gelombang->limit_siswa) * 100, 1) : 0,
            ];
        }

        // ==== GRAFIK PENDAFTAR - 7 HARI TERAKHIR ====
        $startDate = Carbon::now()->subDays(7);

        $dataPendaftar = FormulirPendaftaran::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
            ->where('status_verifikasi', 'diverifikasi')
            ->whereDate('created_at', '>=', $startDate)
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Buat array untuk chart
        $chartLabelsPendaftar = [];
        $chartDataPendaftar = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $chartLabelsPendaftar[] = $date->format('d M'); // Format: 04 Jan

            $data = $dataPendaftar->firstWhere('tanggal', $dateStr);
            $chartDataPendaftar[] = $data ? (int) $data->total : 0;
        }

        // ==== GRAFIK PEMASUKAN - 6 BULAN TERAKHIR ====
        $startMonth = Carbon::now()->subMonths(5)->startOfMonth();

        $dataIncome = Pembayaran::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as bulan'),
            DB::raw('SUM(jumlah_akhir) as total')
        )
            ->where('status', 'Lunas')
            ->where('created_at', '>=', $startMonth)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $chartLabelsIncome = [];
        $chartDataIncome = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthStr = $date->format('Y-m');
            $chartLabelsIncome[] = $date->format('M Y'); // Format: Jan 2026

            $data = $dataIncome->firstWhere('bulan', $monthStr);
            $chartDataIncome[] = $data ? (float) $data->total : 0;
        }

        return view('admin.dashboard', compact(
            'total_pendaftar',
            'menunggu_verifikasi',
            'total_penerimaan',
            'pembayaran_lunas',
            'total_jurusan',
            'total_gelombang',
            'promo_aktif',
            'pendaftar_baru',
            'gelombangPopuler',
            'totalSlotTersisa',
            'gelombangInfo',
            'chartLabelsPendaftar',
            'chartDataPendaftar',
            'chartLabelsIncome',
            'chartDataIncome',
            'search'
        ));
    }

    public function exportLaporan()
    {
        $filename = 'laporan-ppdb-' . date('Y-m-d_H-i') . '.xlsx';
        return Excel::download(new LaporanPendaftaranExport(), $filename);
    }
}