<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }


    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }




    
}
