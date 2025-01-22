@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Gaji</h1>

    {{-- Filter Bulan dan Tahun --}}
    <form method="GET" action="{{ route('salaries.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="month" class="form-control">
                    @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="year" class="form-control">
                    @foreach(range(now()->year - 5, now()->year) as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    {{-- Statistik Ringkas --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Gaji</h5>
                    <p class="card-text">Rp {{ number_format($totalSalary, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Karyawan Dibayar</h5>
                    <p class="card-text">{{ $salaries->count() }} Karyawan</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Daftar Gaji --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Perusahaan</th>
                <th>Tanggal Pembayaran</th>
                <th>Jumlah Gaji</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salaries as $index => $salary)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $salary->employee->name }}</td>
                <td>{{ $salary->company->name }}</td>
                <td>{{ \Carbon\Carbon::parse($salary->payment_date)->format('d M Y') }}</td>
                <td>Rp {{ number_format($salary->amount, 0, ',', '.') }}</td>
                <td>{{ $salary->note }}</td>
                <td>
                    <a href="{{ route('salaries.edit', $salary->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('salaries.destroy', $salary->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tombol Tambah Gaji --}}
    <a href="{{ route('salaries.create') }}" class="btn btn-primary mt-4">Tambah Gaji Baru</a>
</div>
@endsection