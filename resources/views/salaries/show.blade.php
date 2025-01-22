@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Gaji</h1>

    <div class="form-group">
        <label>Nama Pegawai</label>
        <p>{{ $salary->employee->name }}</p>
    </div>

    <div class="form-group">
        <label>Gaji</label>
        <p>{{ number_format($salary->amount, 2) }}</p>
    </div>

    <div class="form-group">
        <label>Tanggal Pembayaran</label>
        <p>{{ $salary->payment_date }}</p>
    </div>

    <div class="form-group">
        <label>Catatan</label>
        <p>{{ $salary->note }}</p>
    </div>

    <div class="form-group">
        <a href="{{ route('salaries.index') }}" class="btn btn-secondary">Kembali ke Daftar Gaji</a>
    </div>
</div>
@endsection