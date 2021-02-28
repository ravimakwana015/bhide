<?php

namespace App\Mail;

use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class SendLoginDetailsMail extends Mailable
{
    use Queueable, SerializesModels;
    protected  $user;
    protected  $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Login Details')
            ->markdown('emails.send_login_details')
            ->with([
                'user' => $this->user,
                'password' => $this->password,
            ]);
    }
}
