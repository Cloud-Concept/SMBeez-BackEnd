<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupplierAccepted extends Mailable
{
    use Queueable, SerializesModels;


    protected $interest;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($interest)
    {   
        $this->interest = $interest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('You have been accepted for ' . $this->interest->project->project_title . '! What\'s next... ?')->markdown('emails.supplier-accepted')
        ->with([
            'interest' => $this->interest,
        ]);
    }
}
