<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'donation_id',
        'payment_id',
        'payment_method',
        'status',
        'payment_url'
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
