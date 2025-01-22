@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Profil Pengguna</h1>

    <!-- Profil Pengguna -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Tanggal Registrasi:</strong> {{ $user->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <h2 class="mt-4 mb-3">Informasi Perusahaan</h2>

    <!-- Informasi Perusahaan -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <p><strong>Nama Perusahaan:</strong> {{ $company->name }}</p>
            <p><strong>Alamat:</strong> {{ $company->address ?? '-' }}</p>
            <p><strong>Telepon:</strong> {{ $company->phone ?? '-' }}</p>
        </div>
    </div>

    <!-- Tombol Edit Profil dan Kembali -->
    <div class="d-flex justify-content-center mb-3">
        <div>
            <a href="{{ route('profile.edit', $company) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Tombol Hapus Akun di pojok kanan -->
    <div class="d-flex justify-content-center">
        <form action="{{ route('profile.destroy', $company) }}" method="POST" class="d-inline-block w-50">
            @csrf
            @method('DELETE')
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
            </div>
            <button type="submit" class="btn btn-danger w-100">
                <i class="fas fa-trash-alt"></i> Hapus Akun
            </button>
        </form>
    </div>
</div>
@endsection