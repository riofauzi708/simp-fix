@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Daftar Posisi untuk {{ $company->name }}</h1>

    <!-- Navigasi -->
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-lg">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('companies.positions.create', $company) }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> Tambah Posisi
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Cek apakah ada posisi -->
    @if ($positions->isEmpty())
    <div class="alert alert-info text-center">
        Tidak ada posisi untuk perusahaan ini.
    </div>
    @else
    <!-- Tabel Posisi -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nama Posisi</th>
                    <th>Gaji Dasar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($positions as $position)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $position->name }}</td>
                    <td>Rp{{ number_format($position->base_salary, 0, ',', '.') }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('companies.positions.edit', [$company, $position]) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('companies.positions.destroy', [$company, $position]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus posisi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection