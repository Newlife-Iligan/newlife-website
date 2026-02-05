<?php

namespace App\Mail;

use App\Models\Members;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Members $member,
        public User $user,
        public string $password
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your NewLife - Iligan Account Credentials',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.credentials',
            with: [
                'member' => $this->member,
                'user' => $this->user,
                'password' => $this->password,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
