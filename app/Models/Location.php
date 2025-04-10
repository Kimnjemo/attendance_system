<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius',
    ];
}
