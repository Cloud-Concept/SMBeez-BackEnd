<?php

namespace App\Mail\Mod;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;


    protected $company, $moderator;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company, $moderator)
    {
        $this->company = $company;
        $this->moderator = $moderator;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->moderator->email)->subject('مرحباً بك في مشاريع!')->markdown('emails.mod.welcome')
        ->with([
            'company' => $this->company,

        ]);
    }
}
