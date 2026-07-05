<?php

namespace App\Mail;

use App\Models\DataBreach;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DataBreachAuthorityNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly DataBreach $breach) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Melding datalek — '.config('app.name'));
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.data-breach-notification');
    }
}
