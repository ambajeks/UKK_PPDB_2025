@extends('layouts.admin')

@section('title', 'Data Promo')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-tags"></i> Data Promo
    </div>
    <div class="card-body">
        <a href="#" class="btn btn-primary btn-sm mb-3"><i class="bi bi-plus"></i> Tambah Promo</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Diskon</th>
                    <th>Masa Berlaku</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Promo Awal Tahun</td>
                    <td>20%</td>
                    <td>2025-01-01 s/d 2025-02-01</td>
                    <td><button class="btn btn-warning btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Hapus</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
