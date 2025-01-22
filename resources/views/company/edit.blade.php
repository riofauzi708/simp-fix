@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <h1 class="text-center mb-4">Edit Profil Perusahaan</h1>

                    <form method="POST" action="{{ route('company.update', $company) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Input untuk nama perusahaan -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $company->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk alamat -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $company->address) }}">
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk telepon -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telepon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $company->phone) }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input untuk logo -->
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo Perusahaan</label>
                            @if ($company->logo)
                            <div class="mb-3 text-center">
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo Perusahaan" class="img-fluid rounded-3 shadow-sm" style="max-width: 200px;">
                            </div>
                            @else
                            <div class="mb-3 text-center">
                                <div class="bg-light rounded-circle p-4 d-inline-block" style="max-width: 150px; max-height: 150px;">
                                    <i class="fas fa-building fa-3x text-muted"></i>
                                </div>
                                <p class="mt-2">Logo belum diunggah.</p>
                            </div>
                            @endif
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                            @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Kembali -->
                        <div class="d-flex justify-content-between mb-4">
                            <a href="{{ route('company.show', $company->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <!-- Tombol Submit -->
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection