<?php
namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function __construct(){ $this->middleware(['auth','can:admin']); }

    public function index(){
        $kelas = Kelas::with('jurusan')
            ->withCount(['siswa' => function($query) {
                $query->whereNotNull('kelas_id');
            }])
            ->paginate(20);
        
        $totalSiswaTerassign = \App\Models\FormulirPendaftaran::whereNotNull('kelas_id')->count();
        
        return view('admin.kelas.index', compact('kelas', 'totalSiswaTerassign'));
    }

    public function create(){
        $jurusans = Jurusan::all();
        return view('kelas.create',compact('jurusans'));
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
        return redirect()->route('kelas.index')->with('success','Kelas dibuat');
    }

    public function show(Kelas $kela){
        $kela->load(['jurusan', 'siswa']);
        return view('admin.kelas.show', ['kelas' => $kela]);
    }

    public function edit(Kelas $kela){
        $jurusans = Jurusan::all();
        return view('kelas.edit',['kelas'=>$kela,'jurusans'=>$jurusans]);
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
        return redirect()->route('kelas.index')->with('success','Kelas diupdate');
    }

    public function destroy(Kelas $kela){
        $kela->delete();
        return redirect()->route('kelas.index')->with('success','Kelas dihapus');
    }
}
