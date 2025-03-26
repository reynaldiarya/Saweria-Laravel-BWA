<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasUuids;
    
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'amount',
        'message',
        'status',
        'phone_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'uuid');
    }
}
