<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'company_id', 'date', 'status'];

    // Relasi ke pegawai
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relasi ke perusahaan
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Accessor untuk date agar selalu menjadi Carbon instance
    public function getDateAttribute($value)
    {
        return Carbon::parse($value);
    }
}
