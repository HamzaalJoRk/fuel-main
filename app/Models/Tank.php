<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'fuel_type', 'remaining_quantity', 'total_capacity'];

    public function refuelings()
    {
        return $this->hasMany(Refueling::class);
    }
}
