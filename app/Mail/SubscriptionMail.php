<?php

namespace App\Mail;

use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class SubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $filename;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $filename)
    {
        $this->user = $user;
        $this->filename = $filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file = storage_path('app/pdf/' . $this->filename);
        return $this->markdown('emails.subscription')
            ->attach($file,  [
                'as' => $this->filename,
                'mime' => 'application/pdf',
            ])
            ->with([
                'user' => $this->user
            ]);
    }
}
