<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactRequest extends Mailable
{
    use Queueable, SerializesModels;

    protected $company_name, $location, $company_phone, $company_website, $company_email, $linkedin_url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company_name, $location, $company_phone, $company_website, $company_email, $linkedin_url)
    {
        $this->company_name = $company_name;
        $this->location = $location;
        $this->company_phone = $company_phone;
        $this->company_website = $company_website;
        $this->company_email = $company_email;
        $this->linkedin_url = $linkedin_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->subject('Contact Info for company "' . $this->company_name . '"')->markdown('emails.contact-request')
        ->with([
            'company_name' => $this->company_name,
            'location' => $this->location,
            'company_phone' => $this->company_phone,
            'company_website' => $this->company_website,
            'company_email' => $this->company_email,
            'linkedin_url' => $this->linkedin_url,
        ]);
    }
}
