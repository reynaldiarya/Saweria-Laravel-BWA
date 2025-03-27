<?php

namespace App\Events;

use App\Models\Donation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DonationReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('donations.user.'.$this->donation->user_id);
    }

    public function broadcastWith()
    {
        return [
            'donation' => [
                'amount' => $this->donation->amount,
                'name' => $this->donation->name,
                'message' => $this->donation->message,
            ]
        ];
    }

    public function broadcastAs()
    {
        return 'donation.received'; // Harus sama dengan di frontend!
    }
}