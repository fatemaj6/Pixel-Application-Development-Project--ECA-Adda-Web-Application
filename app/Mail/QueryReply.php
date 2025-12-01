<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QueryReply extends Mailable
{
    use Queueable, SerializesModels;

 public $query;
    public $reply;

    public function __construct($query, $reply)
    {
        $this->query = $query;
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject('Reply to your message - ECA Adda')
                    ->view('emails.query.reply')
                    ->with(['query' => $this->query, 'reply' => $this->reply]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Query Reply',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
