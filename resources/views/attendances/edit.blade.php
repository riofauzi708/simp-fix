@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Edit Absensi</h1>

    <form action="{{ route('attendances.update', $attendance) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Tanggal Absensi -->
        <div class="mb-4">
            <label for="date" class="form-label fw-bold">Tanggal Absensi:</label>
            <input type="date" name="date" id="date" class="form-control shadow-sm" value="{{ $attendance->date->format('Y-m-d') }}" required>
        </div>

        <!-- Nama Pegawai -->
        <div class="mb-4">
            <label for="employee_id" class="form-label fw-bold">Nama Pegawai:</label>
            <select name="employee_id" id="employee_id" class="form-select shadow-sm">
                @foreach ($employees as $employee)
                <option value="{{ $employee->id }}" {{ $attendance->employee_id == $employee->id ? 'selected' : '' }}>
                    {{ $employee->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Status Kehadiran -->
        <div class="mb-4">
            <label for="status" class="form-label fw-bold">Status Kehadiran:</label>
            <select name="status" id="status" class="form-select shadow-sm">
                <option value="hadir" {{ $attendance->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="izin" {{ $attendance->status == 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="sakit" {{ $attendance->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                <option value="tanpa_keterangan" {{ $attendance->status == 'tanpa_keterangan' ? 'selected' : '' }}>Tanpa Keterangan</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary w-50 shadow-sm">Simpan Perubahan</button>
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary w-50 shadow-sm">Batal</a>
        </div>
    </form>
</div>
@endsection