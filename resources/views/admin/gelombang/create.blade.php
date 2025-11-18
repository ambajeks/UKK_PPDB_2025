@extends('layouts.admin')
@section('content')
<h3>Buat Gelombang</h3>
<form action="{{ route('admin.gelombang.store') }}" method="POST">
  @include('admin.gelombang._form')
</form>
@endsection
