<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class DonationInvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $donation;
    public $paymentData;

    public function __construct($donation, $paymentData)
    {
        $this->donation = $donation;
        $this->paymentData = $paymentData;
    }

    public function build()
    {
        return $this->subject('Invoice Donasi')
            ->markdown('emails.donation-invoice')
            ->with([
                'donation' => $this->donation,
                'paymentData' => $this->paymentData
            ]);
    }
}

