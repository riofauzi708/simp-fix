@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Daftar Pegawai</h1>
    <h4 class="text-center text-muted">{{ $company->name }}</h4>

    <div class="d-flex justify-content-between align-items-center my-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div class="d-flex">
            <a href="{{ route('companies.positions.index', $company) }}" class="btn btn-info btn-lg me-2">
                <i class="fas fa-briefcase"></i> Atur Divisi
            </a>
            <a href="{{ route('employees.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-user-plus"></i> Tambah Pegawai
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Pencarian -->
    <form class="mb-3" method="GET" action="{{ route('employees.index') }}">
        <div class="input-group">
            <input type="text" class="form-control" id="search" name="search" placeholder="Cari pegawai..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="fas fa-search"></i> Cari
            </button>
        </div>
    </form>

    <!-- Tabel Pegawai -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Posisi</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $index => $employee)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>
                        @if($employee->position)
                        <span class="badge bg-success">{{ $employee->position->name }}</span>
                        @else
                        <span class="badge bg-danger">Posisi Tidak Tersedia</span>
                        @endif
                    </td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->address }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data pegawai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection