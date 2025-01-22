@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Gaji Pegawai</h1>

    <!-- Filter berdasarkan bulan dan tahun -->
    <form action="{{ route('salaries.index') }}" method="GET">
        <div class="row">
            <div class="col-md-3">
                <label for="month">Bulan</label>
                <select name="month" id="month" class="form-control" required>
                    @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}" {{ $month == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="year">Tahun</label>
                <select name="year" id="year" class="form-control" required>
                    @foreach(range(now()->year - 5, now()->year + 1) as $year)
                    <option value="{{ $year }}" {{ $year == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary mt-4">Tampilkan</button>
            </div>
        </div>
    </form>

    <hr>

    <!-- Tampilkan total gaji -->
    <h4>Total Gaji Bulan {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}</h4>
    <p><strong>Rp. {{ number_format($totalSalary, 0, ',', '.') }}</strong></p>

    <!-- Tabel Daftar Gaji -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Tanggal Pembayaran</th>
                <th>Jumlah Gaji</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salaries as $index => $salary)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $salary->employee->name }}</td>
                <td>{{ \Carbon\Carbon::parse($salary->payment_date)->format('d M Y') }}</td>
                <td>Rp. {{ number_format($salary->amount, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('salaries.edit', $salary->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('salaries.destroy', $salary->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data gaji untuk bulan ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection