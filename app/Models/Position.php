<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'base_salary', 'company_id'];

    // Relasi ke perusahaan
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relasi ke pegawai
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
