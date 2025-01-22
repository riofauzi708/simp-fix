@extends('layouts.app')

@section('title', 'Tambah Absensi')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Tambah Absensi Baru</h1>

    <!-- Filter Tanggal -->
    <form action="{{ route('attendances.create') }}" method="GET" id="filterForm" class="mb-4">
        <div class="row align-items-end">
            <div class="col-md-4">
                <label for="date" class="form-label fw-bold">Tanggal Absensi</label>
                <input type="date" name="date" id="date" class="form-control shadow-sm" value="{{ $date }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 shadow-sm">Tampilkan</button>
            </div>
        </div>
    </form>

    <!-- Tabel Absensi -->
    <form action="{{ route('attendances.store') }}" method="POST" id="attendanceForm">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}" id="hiddenDate">

        <div class="table-responsive mb-4">
            <table class="table table-hover table-bordered align-middle text-center shadow-sm">
                <thead class="table-primary">
                    <tr>
                        <th class="py-3">Nama Pegawai</th>
                        <th class="py-3">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                    <tr>
                        <td class="py-2">{{ $attendance->employee->name }}</td>
                        <td class="py-2">
                            <input type="hidden" name="attendance[{{ $attendance->id }}][employee_id]" value="{{ $attendance->employee_id }}">
                            <select name="attendance[{{ $attendance->id }}][status]" class="form-select shadow-sm status-select">
                                <option value="hadir" {{ $attendance->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ $attendance->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ $attendance->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="tanpa_keterangan" {{ $attendance->status == 'tanpa_keterangan' ? 'selected' : '' }}>Tanpa Keterangan</option>
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-success shadow-sm">Simpan Absensi</button>
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary shadow-sm">Batal</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        const statusSelects = document.querySelectorAll('.status-select');

        // Reset form values to default when the date changes
        dateInput.addEventListener('change', function() {
            statusSelects.forEach(select => {
                select.value = 'hadir';
            });
        });
    });
</script>
@endsection