<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Project;
use Carbon\Carbon;

class ExpireProjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:expireprojects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire all projects not awarded over 60 Days and close them.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Project::where('created_at', '<=', Carbon::now('Asia/Dubai')->subDays(60))
        ->update(['status' => 'closed', 'status_on_close' => 'expired']);

        $this->info('All projects passed 60 Days closed automatically.');
    }
}
