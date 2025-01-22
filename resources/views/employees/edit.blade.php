@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Edit Pegawai</h2>

    <!-- Menampilkan pesan sukses atau error -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Kolom kiri untuk form inputs -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="phone">Telepon</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" required>
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Kolom kanan untuk form inputs -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="address">Alamat</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $employee->address) }}</textarea>
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="position_id">Posisi</label>
                    <select class="form-control @error('position_id') is-invalid @enderror" id="position_id" name="position_id" required>
                        <option value="">Pilih Posisi</option>
                        @foreach($positions as $position)
                        <option value="{{ $position->id }}" @if(old('position_id', $employee->position_id) == $position->id) selected @endif>
                            {{ $position->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('position_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="salary">Gaji</label>
                    <input type="number" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ old('salary', $employee->salary->amount ?? '') }}" required>
                    @error('salary')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Kolom kiri untuk form inputs -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="join_date">Tanggal Bergabung</label>
                    <input type="date" class="form-control @error('join_date') is-invalid @enderror" id="join_date" name="join_date" value="{{ old('join_date', \Carbon\Carbon::parse($employee->join_date)->format('Y-m-d')) }}" required>
                    @error('join_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="is_active">Status Aktif</label>
                    <select class="form-control @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                        <option value="1" @if(old('is_active', $employee->is_active) == 1) selected @endif>Aktif</option>
                        <option value="0" @if(old('is_active', $employee->is_active) == 0) selected @endif>Non-Aktif</option>
                    </select>
                    @error('is_active')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Kolom kanan untuk foto pegawai -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="photo">Foto</label>
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                    @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($employee->photo)
                    <div class="mt-2">
                        <label>Foto Saat Ini:</label>
                        <br>
                        <img src="{{ Storage::url($employee->photo) }}" alt="Foto Pegawai" class="img-thumbnail" width="150">
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-primary">Perbarui Pegawai</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection