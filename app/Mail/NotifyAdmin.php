<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $type, $slug, $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($type, $slug, $title)
    {
        $this->type = $type;
        $this->slug = $slug;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->subject('New "' . $this->type . '" ' .  $this->title)->markdown('emails.notify-admin')
        ->with([
            'type' => $this->type,
            'slug' => $this->slug,
            'title' => $this->title,
        ]);
    }
}
