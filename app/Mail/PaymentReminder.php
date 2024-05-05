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

class PaymentReminder extends Mailable
{
    use Queueable, SerializesModels;
    public $userName;
    public $subject;
    public $order;
    public $url;
    public $products, $packages, $memberships;

    public $subtotal, $descuento, $total;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order,)
    {

        $this->subject = "Material didáctico MaCa - Regresa por tu carrito";
        $this->userName = $order->user->name;
        $this->order = $order->id;
        $this->subtotal = $order->amount;
        $this->descuento = $order->amount * .10;
        $this->total = $this->subtotal - $this->descuento;


        //$this->products = Order_Details::where('order_id', $this->order)->where('product_id', '!=', null)->get();
        //$this->packages = Order_Details::where('order_id', $this->order)->where('package_id', '!=', null)->get();
        //$this->membreships = Order_Details::where('order_id', $this->order)->where('membership_id', '!=', null)->get();

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

        $this->url = $order->link;
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
            markdown: 'mail.payment-reminder',
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
