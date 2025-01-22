@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Detail Pegawai</h1>
    <h3 class="text-muted text-center">{{ $employee->name }}</h3>

    <!-- Tombol Kembali -->
    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary mb-4">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="row">
        <!-- Kolom kiri untuk informasi pegawai -->
        <div class="col-md-6">
            <div class="list-group">
                <div class="list-group-item"><strong>Nama:</strong> {{ $employee->name }}</div>
                <div class="list-group-item"><strong>Email:</strong> {{ $employee->email }}</div>
                <div class="list-group-item"><strong>Posisi:</strong> {{ $employee->position->name }}</div>
                <div class="list-group-item"><strong>Telepon:</strong> {{ $employee->phone }}</div>
                <div class="list-group-item"><strong>Alamat:</strong> {{ $employee->address }}</div>
                <div class="list-group-item"><strong>Gaji:</strong> {{ $salary ? 'Rp' . number_format($salary->amount, 0, ',', '.') : 'Belum ada gaji' }}</div>
                <div class="list-group-item"><strong>Status:</strong> <span class="badge {{ $employee->is_active ? 'bg-success' : 'bg-danger' }}">{{ $employee->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></div>
            </div>
        </div>

        <!-- Kolom kanan untuk foto dan tombol aksi -->
        <div class="col-md-6 d-flex flex-column align-items-center">
            @if($employee->photo)
            <img src="{{ asset('storage/' . $employee->photo) }}" alt="Foto Pegawai" class="img-thumbnail mb-3" style="width: 250px; height: auto;">
            @else
            <p class="text-muted">Tidak ada foto pegawai</p>
            @endif

            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning mb-3 w-100"><i class="fas fa-edit"></i> Edit</a>

            <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')" class="w-100">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger w-100"><i class="fas fa-trash-alt"></i> Hapus</button>
            </form>
        </div>
    </div>

    <!-- Kehadiran Pegawai Bulan Ini -->
    <h3 class="mt-4 text-center">Kehadiran Bulan {{ now()->monthName }} {{ now()->year }}</h3>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="table-dark text-center align-middle">
                        <th>Tanggal</th>
                        <th>Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->date->format('d-m-Y') }}</td>
                        <td class="text-center">
                            <span class="badge 
                        {{ 
                            $attendance->status === 'hadir' ? 'bg-success' : 
                            ($attendance->status === 'izin' ? 'bg-warning' : 
                            ($attendance->status === 'sakit' ? 'bg-secondary' : 'bg-danger')) 
                        }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center">Tidak ada data kehadiran bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr class="text-center align-middle">
                        <td colspan="2">Total Kehadiran: {{ $attendances->count() }} Hari</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Ringkasan Kehadiran, Potongan, Bonus, dan Gaji -->
    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Kehadiran Bulan Ini</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Hadir:</strong> {{ $attendances->where('status', 'hadir')->count() }}</li>
                        <li class="list-group-item"><strong>Izin:</strong> {{ $attendances->where('status', 'izin')->count() }}</li>
                        <li class="list-group-item"><strong>Sakit:</strong> {{ $attendances->where('status', 'sakit')->count() }}</li>
                        <li class="list-group-item"><strong>Tanpa Keterangan:</strong> {{ $attendances->where('status', 'tanpa_keterangan')->count() }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm mb-2">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Pinalti Kehadiran</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Tanpa Keterangan: Rp{{ number_format($penaltyAmount ?? 0, 0, ',', '.') }}</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mb-2">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Bonus Kehadiran</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Bonus Hadir: Rp{{ number_format($bonusAmount ?? 0, 0, ',', '.') }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Total Gaji</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Gaji Bulan Ini: Rp{{ number_format($employee->salary->amount, 0, ',', '.') }}</li>
                        <li class="list-group-item">Total Potongan: Rp{{ number_format($penaltyAmount ?? 0, 0, ',', '.') }}</li>
                        <li class="list-group-item">Total Bonus: Rp{{ number_format($bonusAmount ?? 0, 0, ',', '.') }}</li>
                        <li class="list-group-item"><strong>Total Gaji: Rp{{ number_format($employee->salary->amount + ($bonusAmount ?? 0) - ($penaltyAmount ?? 0), 0, ',', '.') }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection