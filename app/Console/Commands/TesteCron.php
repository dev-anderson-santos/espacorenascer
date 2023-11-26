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
    protected $signature = 'ander:testecron';

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
        if (now()->format('d') == 1) {
            $this->info('Hoje é o dia de faturar.');
        } else {
            $this->warn('Agendamento não pode ser faturado pois não é o primeiro dia do mês. Data atual: ' . now()->format('d/m/Y'));
        } 
    }
}
