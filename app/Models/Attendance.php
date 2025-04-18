<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

 
    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'latitude',
        'longitude',
        'location_status',
    ];

   



    public function user() {
        return $this->belongsTo(User::class);
    }


    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }




    
}
