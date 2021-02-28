<?php

namespace App\Mail;

use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class SubscriptionPaymentMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $company;
    protected $url;
    /**
     * Create a new message instance.
     *
     * @param object $company
     * @param string $url
     */
    public function __construct(object $company,string $url)
    {
        $this->company = $company;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.subscription_payment')->with([
            'company' => $this->company,
            'url' => $this->url,
        ]);
    }
}
