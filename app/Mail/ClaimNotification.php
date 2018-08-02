<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClaimNotification extends Mailable
{
    use Queueable, SerializesModels;


    protected $company;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company)
    {
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Claim Company Notification "' . $this->company->company_name . '"')->markdown('emails.claim-notification')
        ->with([
            'company' => $this->company,
        ]);
    }
}
