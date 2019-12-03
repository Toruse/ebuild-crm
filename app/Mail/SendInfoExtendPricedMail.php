<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User\User;

class SendInfoExtendPricedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $fields;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $fields)
    {
        $this->user = $user;
        $this->fields = $fields;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.send-info-extend-priced-mail');
    }
}
