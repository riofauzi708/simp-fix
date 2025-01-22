@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Filter -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ url()->current() }}" class="d-flex justify-content-start align-items-center">
                <!-- Filter Bulan -->
                <div class="me-3">
                    <select name="month" class="form-select form-select-sm" aria-label="Pilih Bulan">
                        @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                            {{ Carbon\Carbon::create()->month($month)->format('F') }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tahun -->
                <div>
                    <select name="year" class="form-select form-select-sm" aria-label="Pilih Tahun">
                        @foreach(range(now()->year - 5, now()->year) as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Filter -->
                <button type="submit" class="btn btn-primary btn-sm ms-3">Terapkan</button>
            </form>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="row g-4 mb-5">
        <!-- Card 1: Total Pegawai -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-center">
                <div class="card-body">
                    <div class="text-primary mb-3">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Total Pegawai</h5>
                    <p class="card-text fs-4 text-dark">{{ $totalEmployeesThisMonth ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Persentase Kehadiran -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-center">
                <div class="card-body">
                    <div class="text-success mb-3">
                        <i class="fas fa-calendar-check fa-3x"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Persentase Kehadiran</h5>
                    <p class="card-text fs-4 text-success">{{ $attendancePercentage ?? 0 }}%</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Gaji Bulanan -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-center">
                <div class="card-body">
                    <div class="text-danger mb-3">
                        <i class="fas fa-money-bill-wave fa-3x"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Total Gaji Bulanan</h5>
                    <p class="card-text fs-4 text-danger">Rp {{ number_format($totalSalary ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Employee Growth dan Attendance Trend -->
    <div class="row mb-4">
        <!-- Grafik Employee Growth -->
        <div class="col-md-6">
            <div class="card border-0 shadow-lg">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-dark mb-3">Grafik Pertumbuhan Pegawai</h5>
                    <div style="height: 250px;">
                        {!! $employeeGrowthChart->container() !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Attendance Trend -->
        <div class="col-md-6">
            <div class="card border-0 shadow-lg">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-dark mb-3">Grafik Tren Kehadiran</h5>
                    <div style="height: 250px;">
                        {!! $attendanceTrendChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fitur Utama -->
    <div class="row g-4">
        <!-- Kelola Pegawai -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-center">
                <div class="card-body">
                    <div class="text-primary mb-3">
                        <i class="fas fa-user-tie fa-3x"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Kelola Pegawai</h5>
                    <p class="card-text text-muted">Tambah, edit, dan hapus data pegawai dengan mudah.</p>
                    <a href="{{ route('employees.index') }}" class="btn btn-primary">Akses</a>
                </div>
            </div>
        </div>

        <!-- Absensi -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-center">
                <div class="card-body">
                    <div class="text-success mb-3">
                        <i class="fas fa-clipboard-list fa-3x"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Absensi</h5>
                    <p class="card-text text-muted">Pantau kehadiran pegawai dengan cepat dan efisien.</p>
                    <a href="{{ route('attendances.index') }}" class="btn btn-success">Akses</a>
                </div>
            </div>
        </div>

        <!-- Penggajian -->
        <div class="col-md-4">
            <div class="card border-0 shadow-lg text-center">
                <div class="card-body">
                    <div class="text-warning mb-3">
                        <i class="fas fa-coins fa-3x"></i>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Penggajian</h5>
                    <p class="card-text text-muted">Kelola gaji pegawai dengan sistem penghitungan otomatis.</p>
                    <a href="{{ route('salaries.index') }}" class="btn btn-warning">Akses</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
{!! $employeeGrowthChart->script() !!}
{!! $attendanceTrendChart->script() !!}


@endsection