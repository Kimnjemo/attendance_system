<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
//  return $this->belongsTo(User::class);
protected $fillable = [
    'user_id',
    'from_date',
    'to_date',
    'reason',
    'status', // pending, approved, declined
];


public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
}
