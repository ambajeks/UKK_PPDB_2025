<?php

namespace App\Exports;

use App\Models\FormulirPendaftaran;
use App\Models\Pembayaran;
use App\Models\GelombangPendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanPendaftaranExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new SummarySheet(),
            new GelombangSheet(),
            new PembayaranSheet(),
            new PendaftarSheet(),
        ];
    }
}



class SummarySheet implements FromCollection, WithTitle, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        $totalPendaftar = FormulirPendaftaran::where('status_verifikasi', 'diverifikasi')->count();
        $totalPenerimaan = Pembayaran::where('status', 'Lunas')->sum('jumlah_akhir');
        $pembayaranLunas = Pembayaran::where('status', 'Lunas')->count();
        $menungguVerifikasi = FormulirPendaftaran::where('status_verifikasi', 'menunggu')->count();

        $totalSlotTersisa = 0;
        $gelombangs = GelombangPendaftaran::all();
        foreach ($gelombangs as $gelombang) {
            $terisi = FormulirPendaftaran::where('gelombang_id', $gelombang->id)->count();
            $tersisa = max(0, $gelombang->limit_siswa - $terisi);
            $totalSlotTersisa += $tersisa;
        }

        return collect([
            ['LAPORAN PPDB SMK ANTARTIKA 1 SIDAORJO'],
            ['Tanggal Cetak', now()->format('d F Y H:i:s')],
            [],
            ['SUMMARY'],
            ['Total Pendaftar (Terverifikasi)', $totalPendaftar],
            ['Total Penerimaan', 'Rp ' . number_format($totalPenerimaan, 0, ',', '.')],
            ['Jumlah Pembayaran Lunas', $pembayaranLunas],
            ['Menunggu Verifikasi', $menungguVerifikasi],
            ['Total Slot Gelombang Tersisa', $totalSlotTersisa],
        ]);
    }

    public function title(): string
    {
        return 'SUMMARY';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            4 => ['font' => ['bold' => true]],
        ];
    }
}

class GelombangSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        $gelombangs = GelombangPendaftaran::all();

        $data = [];
        foreach ($gelombangs as $gelombang) {
            $terisi = FormulirPendaftaran::where('gelombang_id', $gelombang->id)->count();
            $tersisa = max(0, $gelombang->limit_siswa - $terisi);
            $persentase = $gelombang->limit_siswa > 0 ? round(($terisi / $gelombang->limit_siswa) * 100, 1) : 0;

            $data[] = [
                $gelombang->nama_gelombang,
                $gelombang->tanggal_mulai,
                $gelombang->tanggal_selesai,
                $gelombang->limit_siswa,
                $terisi,
                $tersisa,
                $persentase . '%',
                'Rp ' . number_format($gelombang->harga, 0, ',', '.'),
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'NAMA GELOMBANG',
            'TANGGAL MULAI',
            'TANGGAL SELESAI',
            'KAPASITAS',
            'TERISI',
            'TERSISA',
            'PERSENTASE',
            'HARGA',
        ];
    }

    public function title(): string
    {
        return 'GELOMBANG';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

class PembayaranSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        $pembayarans = Pembayaran::with(['formulir', 'formulir.jurusan', 'formulir.gelombang'])
            ->where('status', 'Lunas')
            ->latest()
            ->get();

        $data = [];
        foreach ($pembayarans as $pembayaran) {
            $data[] = [
                $pembayaran->kode_transaksi,
                $pembayaran->no_kuitansi ?? '-',
                $pembayaran->formulir->nama_lengkap ?? '-',
                $pembayaran->formulir->jurusan->nama ?? '-',
                $pembayaran->formulir->gelombang->nama_gelombang ?? '-',
                'Rp ' . number_format($pembayaran->jumlah_awal, 0, ',', '.'),
                $pembayaran->promo_voucher_id ? 'Rp ' . number_format(($pembayaran->jumlah_awal - $pembayaran->jumlah_akhir), 0, ',', '.') : '-',
                'Rp ' . number_format($pembayaran->jumlah_akhir, 0, ',', '.'),
                $pembayaran->metode_bayar ?? '-',
                $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d/m/Y H:i') : '-',
                $pembayaran->status,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'KODE TRANSAKSI',
            'NO. KUITANSI',
            'NAMA SISWA',
            'JURUSAN',
            'GELOMBANG',
            'JUMLAH AWAL',
            'POTONGAN',
            'JUMLAH AKHIR',
            'METODE BAYAR',
            'TANGGAL BAYAR',
            'STATUS',
        ];
    }

    public function title(): string
    {
        return 'PEMBAYARAN';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

class PendaftarSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        $pendaftars = FormulirPendaftaran::with(['jurusan', 'gelombang', 'pembayaran', 'kelas'])
            ->where('status_verifikasi', 'diverifikasi')
            ->latest()
            ->get();

        $data = [];
        foreach ($pendaftars as $pendaftar) {
            $data[] = [
                $pendaftar->nomor_pendaftaran ?? '-',
                $pendaftar->nama_lengkap,
                $pendaftar->nisn ?? '-',
                $pendaftar->asal_sekolah,
                $pendaftar->jurusan->nama ?? '-',
                $pendaftar->gelombang->nama_gelombang ?? '-',
                $pendaftar->kelas->nama_kelas ?? 'Belum ditentukan',
                $pendaftar->pembayaran ? $pendaftar->pembayaran->status : 'BELUM BAYAR',
                $pendaftar->status_verifikasi,
                $pendaftar->created_at->format('d/m/Y H:i'),
                $pendaftar->verified_at ? $pendaftar->verified_at->format('d/m/Y H:i') : '-',
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'NO. PENDAFTARAN',
            'NAMA LENGKAP',
            'NISN',
            'ASAL SEKOLAH',
            'JURUSAN',
            'GELOMBANG',
            'KELAS',
            'STATUS PEMBAYARAN',
            'STATUS VERIFIKASI',
            'TANGGAL DAFTAR',
            'VERIFIKASI PADA',
        ];
    }

    public function title(): string
    {
        return 'PENDAFTAR';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}