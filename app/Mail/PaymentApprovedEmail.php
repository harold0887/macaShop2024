<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentApprovedEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $message;
    public $name;
    public $subject;
    public $order;
    public $url;
    public $price;
    public $date;



    public function __construct(Order $order)
    {
        $this->subject = 'Confirmación de compra ' . $order->id;
        $this->name = $order->user->name;
        $this->order = $order->id;
        $this->url = "https://materialdidacticomaca.com/";
        $this->price= $order->amount;
        $this->date= $order->created_at;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.order-success',
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
