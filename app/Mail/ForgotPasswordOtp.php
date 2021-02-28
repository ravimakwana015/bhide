<?php

namespace App\Mail;

use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class ForgotPasswordOtp extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $otp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$otp)
    {
        $this->user=$user;
        $this->otp=$otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.forgot-password-otp')->with([
            'user'=>$this->user,
            'otp' => $this->otp
        ]);
    }
}
