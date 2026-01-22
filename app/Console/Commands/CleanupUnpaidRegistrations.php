<?php

namespace App\Console\Commands;

use App\Models\FormulirPendaftaran;
use App\Models\Pembayaran;
use App\Models\DokumenPendaftaran;
use App\Models\OrangTua;
use App\Models\Wali;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanupUnpaidRegistrations extends Command
{
    protected $signature = 'registration:cleanup-unpaid {--days=3 : Jumlah hari sebelum data dihapus}';
    protected $description = 'Hapus data pendaftaran yang belum dibayar setelah batas waktu tertentu';

    public function handle()
    {
        $days = (int) $this->option('days');
        $cutoffDate = now()->subDays($days);

        $this->info("Mencari pendaftaran yang belum dibayar sebelum: {$cutoffDate->format('Y-m-d H:i:s')}");

        // Cari formulir yang:
        // 1. Dibuat lebih dari X hari yang lalu
        // 2. TIDAK memiliki pembayaran dengan status 'Lunas'
        $expiredFormulirs = FormulirPendaftaran::where('created_at', '<', $cutoffDate)
            ->whereDoesntHave('pembayaran', function ($query) {
                $query->where('status', 'Lunas');
            })
            ->get();

        if ($expiredFormulirs->isEmpty()) {
            $this->info('Tidak ada data yang perlu dihapus.');
            return 0;
        }

        $this->info("Ditemukan {$expiredFormulirs->count()} pendaftaran yang akan dihapus.");

        $deletedCount = 0;
        $errors = [];

        foreach ($expiredFormulirs as $formulir) {
            try {
                DB::beginTransaction();

                $nama = $formulir->nama_lengkap;
                $noPendaftaran = $formulir->nomor_pendaftaran;

                // Hapus data terkait
                DokumenPendaftaran::where('formulir_id', $formulir->id)->delete();
                OrangTua::where('formulir_id', $formulir->id)->delete();
                Wali::where('formulir_id', $formulir->id)->delete();
                Pembayaran::where('formulir_id', $formulir->id)->delete();

                // Hapus formulir
                $formulir->delete();

                DB::commit();

                $deletedCount++;
                $this->line("  ✓ Dihapus: {$nama} ({$noPendaftaran})");

                // Log untuk audit
                Log::info("Cleanup: Formulir dihapus karena tidak membayar dalam {$days} hari", [
                    'nama' => $nama,
                    'nomor_pendaftaran' => $noPendaftaran,
                    'created_at' => $formulir->created_at,
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                $errors[] = "Gagal hapus {$formulir->nama_lengkap}: {$e->getMessage()}";
                $this->error("  ✗ Gagal: {$formulir->nama_lengkap}");
            }
        }

        $this->newLine();
        $this->info("Selesai! {$deletedCount} data berhasil dihapus.");

        if (!empty($errors)) {
            $this->warn("Ada " . count($errors) . " error:");
            foreach ($errors as $error) {
                $this->error("  - {$error}");
            }
        }

        return 0;
    }
}
