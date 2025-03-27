<?php

namespace App\Jobs;

use App\Mail\DonationInvoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendDonationInvoiceMail implements ShouldQueue
{
    use Queueable;

    protected $donation;
    protected $paymentData;

    /**
     * Create a new job instance.
     */
    public function __construct($donation, $paymentData)
    {
        $this->donation = $donation;
        $this->paymentData = $paymentData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->donation->email)
            ->send(new DonationInvoice($this->donation, $this->paymentData));
    }
}
