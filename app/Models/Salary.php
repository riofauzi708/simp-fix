<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'company_id',
        'payment_date',
        'amount',
        'note'
    ];

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
}
