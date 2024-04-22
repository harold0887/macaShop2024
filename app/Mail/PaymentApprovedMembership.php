<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentApprovedMembership extends Mailable
{
    use Queueable, SerializesModels;
    public $userName, $membershipName;
    public $subject;
    public $order;
    public $url;
    public $email;
    public $title;
    public $price;
    use Queueable, SerializesModels;


    public function __construct($idMembership, Order $order)
    {
        $membership = Membership::findOrFail($idMembership);
        $this->subject = "Confirmación de compra membresía " . $membership->title;
        $this->userName = $order->user->name;
        $this->membershipName = $membership->title;
        $this->order = $order->id;
        $this->title = "Membresía " . $membership->title;
        $this->price = $order->amount;
        $this->email = $order->user->email;
        $this->url = "https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20membres%C3%ADa%20" . $membership->title . "%20-%20compra%20web: " . $order->id . " - " . $order->user->email;
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
            markdown: 'mail.order-success-membership',
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
