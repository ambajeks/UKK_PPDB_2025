@extends('layouts.admin')

@section('title', 'Data Kelas')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-collection"></i> Data Kelas
    </div>
    <div class="card-body">
        <a href="#" class="btn btn-primary btn-sm mb-3"><i class="bi bi-plus"></i> Tambah Kelas</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kelas</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>X RPL 1</td>
                    <td>RPL</td>
                    <td><button class="btn btn-warning btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Hapus</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
