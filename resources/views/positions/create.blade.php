@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Tambah Posisi untuk {{ $company->name }}</h1>

    <!-- Pesan Error -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Tambah Posisi -->
    <form action="{{ route('companies.positions.store', $company) }}" method="POST">
        @csrf

        <!-- Nama Posisi -->
        <div class="form-group mb-3">
            <label for="name">Nama Posisi</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required placeholder="Masukkan nama posisi">
        </div>

        <!-- Gaji Dasar -->
        <div class="form-group mb-3">
            <label for="base_salary">Gaji Dasar</label>
            <input type="number" name="base_salary" id="base_salary" class="form-control" value="{{ old('base_salary') }}" required placeholder="Masukkan gaji dasar">
        </div>

        <!-- Tombol Simpan dan Kembali -->
        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('companies.positions.index', $company) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection