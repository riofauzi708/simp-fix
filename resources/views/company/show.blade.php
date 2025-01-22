@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <h1 class="text-center mb-4 text-primary">Profil Perusahaan</h1>

                    <!-- Logo Perusahaan -->
                    <div class="text-center mb-4">
                        @if ($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo Perusahaan" class="img-fluid rounded-circle border border-3 border-primary" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                        <div class="bg-light rounded-circle p-4" style="width: 150px; height: 150px; display: inline-block; object-fit: cover;">
                            <i class="fas fa-building fa-4x text-muted"></i>
                        </div>
                        <p class="mt-2 text-muted">Logo belum diunggah.</p>
                        @endif
                    </div>

                    <!-- Nama Perusahaan -->
                    <h2 class="text-center mb-3 text-dark">{{ $company->name }}</h2>

                    <!-- Alamat dan Telepon -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <p><strong><i class="fas fa-map-marker-alt text-primary"></i> Alamat:</strong> {{ $company->address ?? 'Belum diisi' }}</p>
                            <p><strong><i class="fas fa-phone-alt text-primary"></i> Telepon:</strong> {{ $company->phone ?? 'Belum diisi' }}</p>
                        </div>
                    </div>

                    <!-- Tombol Edit Profil dan Kembali -->
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('company.edit', $company) }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Menampilkan pesan sukses jika ada -->
            @if (session('success'))
            <div class="alert alert-success mt-3 text-center">
                {{ session('success') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection