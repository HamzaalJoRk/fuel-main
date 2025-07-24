<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'fuel_type', 'monthly_allowance', 'section_id', 'plate_number','car_type','restDues'];

    public function drivers()
    {
        return $this->hasMany(Driver::class,'car_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function refuelings()
    {
        return $this->hasMany(Refueling::class);
    }
}
