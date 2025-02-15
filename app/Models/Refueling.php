<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refueling extends Model
{
    use HasFactory;

    protected $fillable = ['car_id', 'tank_id', 'filled_quantity', 'date'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function tank()
    {
        return $this->belongsTo(Tank::class);
    }
}
