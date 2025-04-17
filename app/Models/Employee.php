<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'users'; // Point to the users table


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'api_token', // Optional: if you use it
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Optional: Limit only employee role
    protected static function booted(): void
    {
        static::addGlobalScope('employee', function ($query) {
            $query->where('role', 'employee');
        });
    }
}
