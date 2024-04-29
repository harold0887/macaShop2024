<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnvioMaterial extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $name;
    public $subject;
    public $format;
    public $articles;
    public $document;
    public $folio;
    public $userName;
    public function __construct($product)
    {
        $name = explode(" ", Auth::user()->name);
        $this->subject = $product->title;
        $this->name = $product->name;
        $this->format = $product->format;
        $this->document = $product->document;
        $this->folio = $product->folio;
        $this->userName = $name[0];
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
            markdown: 'mail.resend',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {

        if ($this->format == 'pdf' && $this->folio == true) { //enviar PDF con folio

            return [
                Attachment::fromPath('./pdf/newpdf.pdf')
                    ->as($this->name)
                    ->withMime('application/pdf'),
            ];
        } else { //enviar Power point o pdf sin folio

            return [
                Attachment::fromPath('public/storage/' . $this->document)
                    ->as($this->name)
            ];
        }
    }
}
