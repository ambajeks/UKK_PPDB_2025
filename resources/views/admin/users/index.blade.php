@extends('layouts.admin')

@section('title', 'Data Users')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-people-fill"></i> Data Users
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                    <td><button class="btn btn-warning btn-sm">Edit</button> <button class="btn btn-danger btn-sm">Hapus</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
