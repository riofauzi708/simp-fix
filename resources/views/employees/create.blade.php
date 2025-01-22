@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Pegawai - {{ $company->name }}</h1>

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
            <!-- Nama -->
            <div class="col-md-6">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama pegawai">
            </div>

            <!-- Email -->
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email pegawai">
            </div>

            <!-- Telepon -->
            <div class="col-md-6">
                <label for="phone" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="Masukkan nomor telepon">
            </div>

            <!-- Tanggal Bergabung -->
            <div class="col-md-6">
                <label for="join_date" class="form-label">Tanggal Bergabung</label>
                <input type="date" class="form-control" id="join_date" name="join_date" value="{{ old('join_date') }}" required>
            </div>

            <!-- Alamat -->
            <div class="col-md-12">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control" id="address" name="address" rows="2" required placeholder="Masukkan alamat pegawai">{{ old('address') }}</textarea>
            </div>

            <!-- Posisi -->
            <div class="col-md-6">
                <label for="position_id" class="form-label">Posisi</label>
                <select class="form-control" id="position_id" name="position_id" required>
                    <option value="" disabled selected>Pilih posisi</option>
                    @foreach($positions as $position)
                    <option value="{{ $position->id }}" data-salary="{{ $position->base_salary }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                        {{ $position->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Gaji -->
            <div class="col-md-6">
                <label for="salary" class="form-label">Gaji</label>
                <input type="number" class="form-control" id="salary" name="salary" value="{{ old('salary') }}" required placeholder="Masukkan gaji pegawai">
            </div>

            <!-- Status Pegawai -->
            <div class="col-md-6">
                <label for="is_active" class="form-label">Status Pegawai</label>
                <select name="is_active" id="is_active" class="form-control">
                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <!-- Foto Pegawai -->
            <div class="col-md-6">
                <label for="photo" class="form-label">Foto Pegawai</label>
                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center mt-4">
            <a href="{{ route('employees.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

{{-- Script untuk update otomatis gaji berdasarkan posisi --}}
<script>
    document.getElementById('position_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const baseSalary = selectedOption.getAttribute('data-salary');

        if (baseSalary) {
            document.getElementById('salary').value = baseSalary;
        }
    });
</script>
@endsection