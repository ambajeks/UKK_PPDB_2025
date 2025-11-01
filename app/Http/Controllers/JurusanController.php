<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel jurusan
        $jurusan = Jurusan::all();

        // Kirim data ke view
        return view('admin.jurusan.index', compact('jurusan'));
    }

    public function create()
    {
        return view('admin.jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kode_jurusan' => 'required|string|max:10|unique:jurusan'
        ]);

        Jurusan::create($request->all());
        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'kode_jurusan' => 'required|string|max:10|unique:jurusan,kode_jurusan,' . $id
        ]);

        $jurusan->update($request->all());
        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
