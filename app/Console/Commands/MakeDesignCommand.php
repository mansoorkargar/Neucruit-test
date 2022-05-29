<?php

namespace App\Console\Commands;

use App\Jobs\MakeDesignJob;
use Illuminate\Console\Command;

class MakeDesignCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:set-default-design';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     *
     */
    public function handle()
    {
        MakeDesignJob::dispatch();
    }
}
