@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Gaji Pegawai</h1>

    <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="employee_id">Nama Pegawai</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
                @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ $employee->id == $salary->employee_id ? 'selected' : '' }}>
                    {{ $employee->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="payment_date">Tanggal Pembayaran</label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ $salary->payment_date->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label for="amount">Jumlah Gaji</label>
            <input type="number" name="amount" id="amount" class="form-control" value="{{ $salary->amount }}" required>
        </div>

        <div class="form-group">
            <label for="note">Catatan (Opsional)</label>
            <textarea name="note" id="note" class="form-control">{{ $salary->note }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection