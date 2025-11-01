@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-diagram-3"></i> Data Jurusan
            </h5>
            <a href="{{ route('admin.jurusan.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Jurusan
            </a>
        </div>
        <div class="card-body">
            <p class="text-muted">Daftar semua jurusan yang tersedia di sistem.</p>
            <table class="table table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nama Jurusan</th>
                        <th>Kode Jurusan</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jurusan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kode_jurusan }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.jurusan.edit', $item->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.jurusan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jurusan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Belum ada data jurusan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
