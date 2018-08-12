<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClaimDeclined extends Mailable
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
        return $this->subject('مطلوب بيانات إضافية "' . $this->company->company_name . '"')->markdown('emails.claim-declined')
        ->with([
            'company' => $this->company,
        ]);
    }
}
