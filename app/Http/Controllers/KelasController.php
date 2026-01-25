<?php
namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\FormulirPendaftaran;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function __construct(){ $this->middleware(['auth','can:admin']); }

    /**
     * Tampilkan daftar jurusan dengan statistik kelas
     */
    public function index(){
        $jurusans = Jurusan::withCount('kelas')
            ->with(['kelas' => function($query) {
                $query->withCount(['siswa' => function($q) {
                    $q->whereNotNull('kelas_id');
                }]);
            }])
            ->get()
            ->map(function($jurusan) {
                // Hitung total siswa dan kapasitas
                $totalSiswa = $jurusan->kelas->sum('siswa_count');
                $totalKapasitasAwal = Kelas::where('jurusan_id', $jurusan->id)->count() > 0
                    ? $totalSiswa + $jurusan->kelas->sum('kapasitas')
                    : 0;
                $slotTersedia = $jurusan->kelas->sum('kapasitas');
                
                $jurusan->total_siswa = $totalSiswa;
                $jurusan->total_kapasitas = $totalKapasitasAwal;
                $jurusan->slot_tersedia = $slotTersedia;
                $jurusan->is_penuh = $slotTersedia <= 0 && $jurusan->kelas_count > 0;
                
                return $jurusan;
            });
        
        $totalKelas = Kelas::count();
        $totalSiswaTerassign = FormulirPendaftaran::whereNotNull('kelas_id')->count();
        
        return view('admin.kelas.index', compact('jurusans', 'totalKelas', 'totalSiswaTerassign'));
    }

    /**
     * Halaman kelola kelas per jurusan
     */
    public function manage(Jurusan $jurusan){
        $kelas = Kelas::where('jurusan_id', $jurusan->id)
            ->withCount(['siswa' => function($query) {
                $query->whereNotNull('kelas_id');
            }])
            ->orderBy('nama_kelas', 'asc')
            ->get()
            ->map(function($k) {
                // Hitung kapasitas awal (kapasitas sisa + siswa yang sudah assign)
                $k->kapasitas_awal = $k->kapasitas + $k->siswa_count;
                return $k;
            });
        
        // Statistik jurusan
        $totalSiswa = $kelas->sum('siswa_count');
        $totalKapasitas = $kelas->sum('kapasitas_awal');
        $slotTersedia = $kelas->sum('kapasitas');
        
        return view('admin.kelas.manage', compact('jurusan', 'kelas', 'totalSiswa', 'totalKapasitas', 'slotTersedia'));
    }

    /**
     * Bulk create kelas
     */
    public function bulkStore(Request $request, Jurusan $jurusan){
        $data = $request->validate([
            'jumlah_kelas' => 'required|integer|min:1|max:20',
            'kapasitas' => 'required|integer|min:1|max:100',
            'tipe_kelas' => 'required|in:Reguler,Unggulan',
            'tahun_ajaran' => 'required|digits:4'
        ]);

        // Cari nomor kelas terakhir untuk jurusan ini
        $lastKelas = Kelas::where('jurusan_id', $jurusan->id)
            ->orderBy('nama_kelas', 'desc')
            ->first();
        
        $startNumber = 1;
        if ($lastKelas) {
            // Coba extract nomor dari nama kelas (misal: "X TKJ 3" -> 3)
            preg_match('/(\d+)$/', $lastKelas->nama_kelas, $matches);
            if (!empty($matches[1])) {
                $startNumber = (int)$matches[1] + 1;
            }
        }

        // Buat kelas baru
        $createdCount = 0;
        for ($i = 0; $i < $data['jumlah_kelas']; $i++) {
            $namaKelas = 'X ' . $jurusan->kode_jurusan . ' ' . ($startNumber + $i);
            
            Kelas::create([
                'jurusan_id' => $jurusan->id,
                'nama_kelas' => $namaKelas,
                'tipe_kelas' => $data['tipe_kelas'],
                'kapasitas' => $data['kapasitas'],
                'tahun_ajaran' => $data['tahun_ajaran']
            ]);
            $createdCount++;
        }

        return redirect()->route('admin.kelas.manage', $jurusan)
            ->with('success', "Berhasil membuat {$createdCount} kelas baru!");
    }

    public function create(){
        $jurusans = Jurusan::all();
        return view('admin.kelas.create',compact('jurusans'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'jurusan_id'=>'required|exists:jurusan,id',
            'nama_kelas'=>'required|string|max:100',
            'tipe_kelas'=>'required|in:Reguler,Unggulan',
            'kapasitas'=>'required|integer|min:0',
            'tahun_ajaran'=>'required|digits:4'
        ]);
        Kelas::create($data);
        
        $jurusan = Jurusan::find($data['jurusan_id']);
        return redirect()->route('admin.kelas.manage', $jurusan)->with('success','Kelas dibuat');
    }

    public function show(Kelas $kela){
        $kela->load(['jurusan', 'siswa']);
        return view('admin.kelas.show', ['kelas' => $kela]);
    }

    public function edit(Kelas $kela){
        $jurusans = Jurusan::all();
        return view('admin.kelas.edit',['kelas'=>$kela,'jurusans'=>$jurusans]);
    }

    public function update(Request $request, Kelas $kela){
        $data = $request->validate([
            'jurusan_id'=>'required|exists:jurusan,id',
            'nama_kelas'=>'required|string|max:100',
            'tipe_kelas'=>'required|in:Reguler,Unggulan',
            'kapasitas'=>'required|integer|min:0',
            'tahun_ajaran'=>'required|digits:4'
        ]);
        $kela->update($data);
        
        $jurusan = Jurusan::find($data['jurusan_id']);
        return redirect()->route('admin.kelas.manage', $jurusan)->with('success','Kelas diupdate');
    }

    public function destroy(Kelas $kela){
        $jurusan = $kela->jurusan;
        $kela->delete();
        return redirect()->route('admin.kelas.manage', $jurusan)->with('success','Kelas dihapus');
    }
}
