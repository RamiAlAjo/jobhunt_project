<?php

// Define the namespace for the Mailable class used for sending emails
namespace App\Mail;

// Import necessary classes for queuing, email building, and serialization
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// Define the Websitemail class that extends Mailable for constructing and sending email messages
class Websitemail extends Mailable
{
    use Queueable, SerializesModels;

    // Public properties to hold the subject and body of the email
    public $subject, $body;

    /**
     * Create a new message instance.
     *
     * @param string $subject - The subject of the email
     * @param string $body - The body content of the email
     * @return void
     */
    public function __construct($subject, $body)
    {
        // Assign the provided subject and body to the class properties
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Build the email message.
     *
     * @return $this
     */
    public function build()
    {
        // Build the email using the specified view and attach data
        return $this->view('email.email')->with([
            'subject' => $this->subject
        ]);
    }
}