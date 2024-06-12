<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailToUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($status, $user_details, $job_post_details)
    {
        $this->status = $status;
        //echo "<pre>"; print_r($this->status); die;
        $this->user_details = $user_details;
        $this->job_post_details = $job_post_details;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'About Job Status',
        );
    }

    /**
     * Get the message content definition.
     * 
     */

    
    public function content(): Content
    {
        return new Content(
            view: 'emails.to_user',
            with: [
                'status' => $this->status,
                'user_details' => $this->user_details,
                'job_post_details' => $this->job_post_details,
            ]
          
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
