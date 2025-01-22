@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Gaji</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('salaries.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="employee_id" class="form-label">Karyawan</label>
            <select name="employee_id" id="employee_id" class="form-control">
                @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="payment_date" class="form-label">Tanggal Pembayaran</label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Jumlah Gaji</label>
            <input type="number" name="amount" id="amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Catatan</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('salaries.index') }}" class="btn btn-secondary">Kembali</a>
    </form>

</div>
@endsection