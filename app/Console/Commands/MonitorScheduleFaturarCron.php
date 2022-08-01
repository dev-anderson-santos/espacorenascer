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

            $schedules = ScheduleModel::where('status', 'Finalizado')
                ->where('faturado', '!=', 1)
                ->whereBetween('date', [
                    now()->subMonth()->startOfMonth()->format('Y-m-d'),
                    now()->subMonth()->endOfMonth()->format('Y-m-d')
                ])->get();

            $faturado = false;
            foreach ($schedules as $schedule) {
                if (now()->format('d') == 1) {
                    $faturado = $schedule->update(['faturado' => 1]);
                }      
            }

            if ($schedules->count() > 0 && $faturado) {

                DB::commit();

                $this->info('Agendamentos faturados com sucesso! Data atual: ' . now()->format('d/m/Y H:i:s'));
            } else if ($schedules->count() == 0) {
                $this->warn('Não há agendamentos para faturar. Data atual: ' . now()->format('d/m/Y H:i:s'));
            } else if (now()->format('d') != 1 && $schedules->count() > 0) {
                $this->warn('Agendamento não pode ser faturado pois não é o primeiro dia do mês. Data atual: ' . now()->format('d/m/Y H:i:s'));
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
            $this->error('Ocorreu um erro ao faturar os agendamentos.');
        }
    }
}
