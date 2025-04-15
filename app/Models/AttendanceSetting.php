<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    //

    protected $fillable = [
        'start_time',
        'end_time',
        'radius',
        'allow_late_checkin',
        'use_geofence',
    ];
    
}
