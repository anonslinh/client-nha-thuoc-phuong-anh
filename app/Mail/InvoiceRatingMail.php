<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceRatingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $invoice_rating;

    /**
     * Create a new message instance.
     */
    public function __construct($invoice, $invoice_rating)
    {
        $this->invoice = $invoice;
        $this->invoice_rating = $invoice_rating;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Hoá đơn - Đánh giá nguy hiểm')
            ->view('send-emails.mail-invoice-rating');
    }
}
