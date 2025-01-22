<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'position_id',
        'company_id',
        'photo',
        'join_date',
        'is_active',
    ];

    protected $casts = [
        'base_salary' => 'float',
    ];

    protected $dates = ['deleted_at'];

    // Relasi ke posisi
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    // Relasi ke absensi
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Relasi ke gaji
    public function salary()
    {
        return $this->hasOne(Salary::class);
    }


    // Accessor untuk full address
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->position->name}";
    }

    // Mutator untuk memformat nama sebelum disimpan
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
