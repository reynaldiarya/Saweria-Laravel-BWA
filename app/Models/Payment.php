<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasUuids;
    
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'donation_id',
        'payment_id',
        'payment_method',
        'status',
        'payment_url'
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}
