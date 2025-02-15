<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = ['car_id', 'section_id', 'name', 'surname', 'father_name', 'phone'];

    public function car()
    {
        return $this->belongsTo(Car::class,'car_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
