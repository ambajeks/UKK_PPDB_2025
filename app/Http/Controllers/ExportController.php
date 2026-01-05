<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\LaporanPendaftaranExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }
    
    /**
     * Export laporan ke Excel
     */
    public function exportLaporan()
    {
        $filename = 'laporan-ppdb-' . date('Y-m-d_H-i') . '.xlsx';
        
        return Excel::download(new LaporanPendaftaranExport(), $filename);
    }
}