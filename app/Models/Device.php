<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Device extends Model

{

    use HasFactory; // Make sure HasFactory is included for factory use
    
    protected $fillable = [
        'user_id',  // Foreign key for the user
        'device_id',  // Unique device ID (e.g., UUID)
    ];


    public function attendances()
    {
        return $this->belongsTo(User::class);
    }
    
}
