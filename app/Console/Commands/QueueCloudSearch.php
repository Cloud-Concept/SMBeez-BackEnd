<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class QueueCloudSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexing Cloud Search Queue Companies & Projects';

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
        $this->info('Cloud Search EndPoint Updated.');
    }
}
