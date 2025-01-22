@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Profil</h1>
    <form action="{{ route('profile.update', $company) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Pengguna</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <h2>Informasi Perusahaan</h2>
        <div class="mb-3">
            <label for="company_name" class="form-label">Nama Perusahaan</label>
            <input type="text" id="company_name" class="form-control" value="{{ $company->name }}" disabled>
        </div>

        <div class="mb-3">
            <label for="company_address" class="form-label">Alamat Perusahaan</label>
            <input type="text" id="company_address" class="form-control" value="{{ $company->address }}" disabled>
        </div>

        <a href="{{ route('profile.show', $company) }}" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection