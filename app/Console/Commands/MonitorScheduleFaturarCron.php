<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\ScheduleModel;
use App\Models\SettingsModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MonitorScheduleFaturarCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:faturar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fatura cada agendamento finalizado.';

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

            $schedules = ScheduleModel::where('status', 'Finalizado')->get();
            $now = Carbon::now()->format('Y-m-d');

            foreach ($schedules as $schedule) {
                if (/* Carbon::parse($schedule->date)->endOfMonth()->format('Y-m-d') == $now || */Carbon::parse($schedule->date)->format('m') < now()->format('m')) {
                    $schedule->update([
                        'faturado' => 1
                    ]);
                }        
            }

            DB::commit();
            
            $this->info('Agendamentos faturados com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
            $this->error('Ocorreu um erro ao faturar os agendamentos.');
        }
    }
}
