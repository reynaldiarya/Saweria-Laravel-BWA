<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonationInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $donation;
    public $paymentData;

    /**
     * Create a new message instance.
     */
    public function __construct($donation, $paymentData)
    {
        $this->donation = $donation;
        $this->paymentData = $paymentData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Donation Invoice',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.donations.invoice',
            with: [
                'donation' => $this->donation,
                'paymentData' => $this->paymentData
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
