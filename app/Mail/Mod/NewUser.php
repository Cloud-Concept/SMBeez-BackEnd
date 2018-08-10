<?php

namespace App\Mail\Mod;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;


    protected $user, $unique_password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $unique_password)
    {
        $this->user = $user;
        $this->unique_password = $unique_password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('مرحباً بك في مشاريع!')->markdown('emails.mod.newuser')
        ->with([
            'user' => $this->user,
            'unique_password' => $this->unique_password,
        ]);
    }
}
