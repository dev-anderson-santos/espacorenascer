<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TesteCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:testecron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'teste de cron';

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
     * @return int
     */
    public function handle()
    {
        return $this->info('It works!');
    }
}
