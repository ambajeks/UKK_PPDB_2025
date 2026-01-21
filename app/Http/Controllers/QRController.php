<?php

namespace App\Http\Controllers;

use App\Models\FormulirPendaftaran;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QRController extends Controller
{
    /**
     * Handle QR Code scan from PDF document
     * Route: GET /verifikasi/qr/{code}
     */
    public function scanQR($code)
    {
        try {
            // Decode the QR code data
            $decoded = base64_decode($code);
            $parts = explode('|', $decoded);

            if (count($parts) !== 2) {
                return redirect()->route('qr.error')->with('error', 'Kode QR tidak valid.');
            }

            $id = $parts[0];
            $nomorPendaftaran = $parts[1];

            // Log the scan attempt (optional)
            \Log::info('QR Scan Attempt', [
                'id' => $id,
                'nomor_pendaftaran' => $nomorPendaftaran,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'time' => now()
            ]);

            // Find the formulir with relations
            $formulir = FormulirPendaftaran::with(['jurusan', 'gelombang', 'kelas', 'pembayaran'])
                ->where('id', $id)
                ->where('nomor_pendaftaran', $nomorPendaftaran)
                ->first();

            if (!$formulir) {
                return redirect()->route('qr.error')->with('error', 'Data siswa tidak ditemukan.');
            }

            // Check if registration is still valid (optional)
            $registrationDate = Carbon::parse($formulir->created_at);
            $daysDiff = $registrationDate->diffInDays(now());

            if ($daysDiff > 365) { // QR Code valid for 1 year
                return redirect()->route('qr.error')->with('error', 'Kode QR telah kadaluarsa.');
            }

            // Redirect to student data verification page
            return redirect()->route('qr.siswa', ['id' => $formulir->id, 'code' => $code]);

        } catch (\Exception $e) {
            \Log::error('QR Scan Error: ' . $e->getMessage());
            return redirect()->route('qr.error')->with('error', 'Terjadi kesalahan saat memproses QR Code.');
        }
    }

    /**
     * Show student data for verification (public access)
     * Route: GET /verifikasi/siswa/{id}/{code}
     */
    public function showSiswa($id, $code)
    {
        try {
            // Verify the code matches the id
            $decoded = base64_decode($code);
            $parts = explode('|', $decoded);

            if (count($parts) !== 2 || $parts[0] != $id) {
                return redirect()->route('qr.error')->with('error', 'Kode verifikasi tidak valid.');
            }

            // Find the formulir with all necessary relations
            $formulir = FormulirPendaftaran::with([
                'jurusan',
                'gelombang',
                'kelas',
                'pembayaran.promo',
                'user',
                'adminVerifikasi'
            ])->findOrFail($id);

            // Verify nomor pendaftaran matches
            if ($formulir->nomor_pendaftaran != $parts[1]) {
                return redirect()->route('qr.error')->with('error', 'Data tidak konsisten.');
            }

            // Get student photo
            $fotoSiswa = FileUpload::where('formulir_id', $formulir->id)
                ->whereIn('jenis_dokumen', ['foto', 'foto_3x4'])
                ->first();

            // Log successful access
            \Log::info('QR Data Accessed', [
                'id' => $id,
                'nama' => $formulir->nama_lengkap,
                'ip' => request()->ip(),
                'time' => now()
            ]);

            return view('verifikasi.data-siswa', compact('formulir', 'fotoSiswa', 'code'));

        } catch (\Exception $e) {
            \Log::error('QR Data Access Error: ' . $e->getMessage());
            return redirect()->route('qr.error')->with('error', 'Gagal mengakses data siswa.');
        }
    }

    /**
     * Simple student data view without code verification (for admin/internal use)
     * Route: GET /verifikasi/siswa-simple/{id}
     */
    public function showSiswaSimple($id)
    {
        $formulir = FormulirPendaftaran::with(['jurusan', 'gelombang', 'kelas', 'pembayaran'])
            ->findOrFail($id);

        $fotoSiswa = FileUpload::where('formulir_id', $formulir->id)
            ->whereIn('jenis_dokumen', ['foto', 'foto_3x4'])
            ->first();

        return view('verifikasi.data-siswa-simple', compact('formulir', 'fotoSiswa'));
    }

    /**
     * Error page for QR code verification
     * Route: GET /verifikasi/error
     */
    public function error()
    {
        return view('verifikasi.error');
    }

    /**
     * Test QR Code generation (for development)
     * Route: GET /qr/test/{id}
     */
    public function testQR($id)
    {
        $formulir = FormulirPendaftaran::findOrFail($id);

        // Generate QR code data
        $qrData = base64_encode($formulir->id . '|' . $formulir->nomor_pendaftaran);
        $qrUrl = route('qr.scan', ['code' => $qrData]);

        return view('verifikasi.test-qr', compact('formulir', 'qrData', 'qrUrl'));
    }
}