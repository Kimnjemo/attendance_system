<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
        'remember_token',
  

    ];

    public function location()
{
    return $this->belongsTo(\App\Models\Location::class);
}


public function Devices()
{
    return $this->hasOne(Device::class);
}



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    public function isAdmin(): bool
{
    return $this->role === 'admin';
}

public function isHR(): bool
{
    return $this->role === 'hr';
}

public function isEmployee(): bool
{
    return $this->role === 'employee';
}




    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($user) {
            $user->api_token = Str::random(60);
        });
    }
    


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
