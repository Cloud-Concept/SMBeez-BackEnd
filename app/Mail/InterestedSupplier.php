<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InterestedSupplier extends Mailable
{
    use Queueable, SerializesModels;

    protected $project;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('لديك شركة جديدة مهتمة بمشروعك "' . $this->project->project_title . '"')->markdown('emails.interested-supplier')
        ->with([
            'project' => $this->project,
        ]);
    }
}
