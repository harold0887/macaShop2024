<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Order_Details;
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
    public $products, $packages, $memberships;



    public function __construct(Order $order)
    {
        $this->subject = 'Confirmación de compra ' . $order->id;
        $this->name = $order->user->name;
        $this->order = $order->id;
        $this->url = "https://materialdidacticomaca.com/";
        $this->price = $order->amount;
        $this->date = $order->created_at;

        $this->products = Order_Details::whereHas('order', function ($query) {
            $query->where('orders.id', $this->order);
        })->where('order_details.product_id', '!=', null)
            ->get();

        $this->packages = Order_Details::whereHas('order', function ($query) {
            $query->where('orders.id', $this->order);
        })->where('order_details.package_id', '!=', null)
            ->get();


        $this->memberships = Order_Details::whereHas('order', function ($query) {
            $query->where('orders.id', $this->order);
        })->where('order_details.membership_id', '!=', null)
            ->get();
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
