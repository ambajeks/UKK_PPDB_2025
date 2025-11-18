@extends('layouts.admin')
@section('content')
<h3>Edit Gelombang</h3>
<form action="{{ route('admin.gelombang.update', $gelombang) }}" method="POST">
  @method('PUT')
  @include('admin.gelombang._form')
</form>
@endsection
