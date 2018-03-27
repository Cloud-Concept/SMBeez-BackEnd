<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectPublished extends Mailable
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
        return $this->subject('Your project is now live: ' . $this->project->project_title)->markdown('emails.project-published')
        ->with([
            'project' => $this->project,
        ]);
    }
}
