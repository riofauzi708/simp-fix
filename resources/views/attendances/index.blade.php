@extends('layouts.app')

@section('title', 'Daftar Absensi')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Daftar Absensi</h1>

    <!-- Filter Tanggal -->
    <form action="{{ route('attendances.index') }}" method="GET" class="mb-4">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label for="date" class="form-label fw-bold">Pilih Tanggal</label>
                <input type="date" name="date" id="date" class="form-control shadow-sm" value="{{ $date }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 shadow-sm">Filter</button>
            </div>
            <div class="col-md-2 ms-auto">
                <a href="{{ route('attendances.create') }}" class="btn btn-success w-100 shadow-sm">Buat Absensi</a>
            </div>
        </div>
    </form>

    <!-- Tabel Absensi -->
    <div class="table-responsive mb-4">
        <table class="table table-striped table-bordered align-middle text-center shadow-sm">
            <thead class="table-primary">
                <tr>
                    <th class="py-3">Nama Pegawai</th>
                    <th class="py-3">Tanggal</th>
                    <th class="py-3">Status Kehadiran</th>
                    <th class="py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $attendance)
                <tr>
                    <td class="py-2">{{ $attendance->employee->name }}</td>
                    <td class="py-2">{{ \Carbon\Carbon::parse($attendance->date)->format('d F Y') }}</td>
                    <td class="py-2">
                        <span class="badge 
                            @if($attendance->status == 'hadir') bg-success 
                            @elseif($attendance->status == 'izin') bg-warning 
                            @elseif($attendance->status == 'sakit') bg-secondary 
                            @else bg-danger 
                            @endif">
                            {{ ucfirst($attendance->status) }}
                        </span>
                    </td>
                    <td class="d-flex justify-content-center gap-2">
                        <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-warning btn-sm shadow-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus absensi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-3">Tidak ada data absensi untuk tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $attendances->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection