<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\SchedulesNextMonthModel;

class ScheduleDeleteMirroredCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:delete-mirrored';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exclui Agendamentos espelhados do mês anterior.';

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
        try {
            DB::beginTransaction();
            
            SchedulesNextMonthModel::whereMonth('date', now()->format('m'))->delete();

            DB::commit();
            
            $this->info('Agendamentos excluídos com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
            $this->error('Ocorreu um erro ao excluir os agendamentos espelhados do mês anterior.');
        }
    }
}
