<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'phone'];

    // Relasi ke posisi
    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    // Relasi ke pegawai
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    // Relasi ke pengguna
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relasi ke kehadiran
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Relasi ke gaji
    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }
}
