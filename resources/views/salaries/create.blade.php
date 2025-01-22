@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Gaji Pegawai</h1>

    <form action="{{ route('salaries.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="employee_id">Nama Pegawai</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
                @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="payment_date">Tanggal Pembayaran</label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="amount">Jumlah Gaji</label>
            <input type="number" name="amount" id="amount" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="note">Catatan (Opsional)</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection