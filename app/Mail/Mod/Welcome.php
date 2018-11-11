<?php

namespace App\Mail\Mod;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;


    protected $company, $moderator, $moderator_name, $moderator_sign, $moderator_phone;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company, $moderator, $moderator_name, $moderator_sign, $moderator_phone)
    {
        $this->company = $company;
        $this->moderator = $moderator;
        $this->moderator_name = $moderator_name,
        $this->moderator_sign = $moderator_sign,
        $this->moderator_phone = $moderator_phone,
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->moderator)->subject('مرحباً بك في مشاريع!')->markdown('emails.mod.welcome')
        ->with([
            'company' => $this->company,
            'mod_name' => $this->moderator_name,
            'mod_sign' => $this->moderator_sign,
            'mod_phone' => $this->moderator_phone,

        ]);
    }
}
