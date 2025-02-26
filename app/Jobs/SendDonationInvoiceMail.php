<?php

namespace App\Jobs;

use App\Mail\DonationInvoiceMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendDonationInvoiceMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $donation;
    protected $paymentData;

    public function __construct($donation, $paymentData)
    {
        $this->donation = $donation;
        $this->paymentData = $paymentData;
    }

    public function handle()
    {
        Mail::to($this->donation->email)
            ->send(new DonationInvoiceMail($this->donation, $this->paymentData));
    }
}

