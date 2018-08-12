<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupplierRejected extends Mailable
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
        return $this->subject('تم رفضك لمشروع ' . $this->interest->project->project_title)->markdown('emails.supplier-rejected')
        ->with([
            'interest' => $this->interest,
        ]);
    }
}
