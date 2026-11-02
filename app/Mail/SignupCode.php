<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/** The 6-digit code that confirms a new account's email (/signup); valid 10 minutes. */
class SignupCode extends Mailable
{
    public function __construct(public string $name, public string $code) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: "{$this->code} is your ".Setting::get('store_name').' verification code');
    }

    public function content(): Content
    {
        return new Content(view: 'mail.signup-code');
    }
}
