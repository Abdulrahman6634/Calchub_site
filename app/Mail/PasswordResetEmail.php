<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationCode;
    public $userName;
    public $expiryMinutes;

    public function __construct($verificationCode, $userName = null)
    {
        $this->verificationCode = $verificationCode;
        $this->userName = $userName;
        $this->expiryMinutes = 15;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Reset Verification Code - CalcHub',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset',
            with: [
                'verificationCode' => $this->verificationCode,
                'userName' => $this->userName,
                'expiryMinutes' => $this->expiryMinutes,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}