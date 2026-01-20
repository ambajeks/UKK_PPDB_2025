<?php

namespace App\Http\Controllers;

use App\Models\FormulirPendaftaran;
use App\Models\Pembayaran;
use App\Models\OrangTua;
use App\Models\Wali;
use App\Models\DokumenPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StatusPendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $formulir = $user->formulir()->first();

        if (!$formulir) {
            abort(404, 'Halaman tidak ditemukan');
        }

        $pembayaran = Pembayaran::where('formulir_id', $formulir->id)->first();
        $dokumen = DokumenPendaftaran::where('formulir_id', $formulir->id)->exists();
        $orangTua = OrangTua::where('formulir_id', $formulir->id)->exists();
        $wali = Wali::where('formulir_id', $formulir->id)->exists();

        // Ambil revisi yang menunggu jika ada
        $revisiMenunggu = $formulir->getRevisiMenunggu();

        $progress = $this->getProgress($formulir, $pembayaran, $dokumen, $orangTua, $wali);
        // dd($formu
        // lir);

        // dd($pembayaran);
        return view('status-pendaftaran.index', compact('formulir', 'pembayaran', 'progress', 'revisiMenunggu'));
    }

    private function getProgress($formulir, $pembayaran, $dokumen, $orangTua, $wali)
    {
        return [
            'akun' => [
                'completed' => true,
                'label' => 'Buat Akun'
            ],
            'formulir' => [
                'completed' => !is_null($formulir),
                'label' => 'Isi Formulir'
            ],
            'dokumen' => [
                'completed' => $dokumen,
                'label' => 'Upload Dokumen'
            ],
            'orang_tua' => [
                'completed' => $orangTua || $wali,
                'label' => 'Data Orang Tua'
            ],
            'pembayaran' => [
                'completed' => $pembayaran && $pembayaran->status === 'Lunas',
                'label' => 'Pembayaran & Verifikasi',
                'status' => $pembayaran ? $pembayaran->status : 'belum_bayar'
            ],
            'cetak_pdf' => [
                'completed' => $formulir && $formulir->status_verifikasi === 'diverifikasi',
                'label' => 'Cetak PDF Bukti Pendaftaran'
            ]
        ];
    }

    public function cetakPdf($id)
    {
        $formulir = FormulirPendaftaran::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Cek apakah sudah terverifikasi
        if ($formulir->status_verifikasi !== 'diverifikasi') {
            return redirect()->route('status-pendaftaran.index')
                ->with('error', 'Anda belum dapat mencetak PDF. Tunggu verifikasi admin.');
        }

        // Generate QR Code
        $qrData = base64_encode($formulir->id . '|' . $formulir->nomor_pendaftaran);
        $qrUrl = route('qr.scan', ['code' => $qrData]);

        // Generate QR Code sebagai string SVG
        $qrCodeSvg = QrCode::size(120)->margin(1)->generate($qrUrl);

        // Convert SVG to data URI
        $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.bukti-pendaftaran', [
            'formulir' => $formulir,
            'qrCodeImage' => $qrCodeBase64 // Kirim ke view
        ]);

        return $pdf->download('bukti-pendaftaran-' . $formulir->nomor_pendaftaran . '.pdf');
    }
}
