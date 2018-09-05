<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReviewSubmittedOwner extends Mailable
{
    use Queueable, SerializesModels;


    protected $review;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($review)
    {
        $this->review = $review;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('لقد حصلت على تقييم جديد!')->markdown('emails.review-submitted-owner')
        ->with([
            'review' => $this->review,
        ]);
    }
}
