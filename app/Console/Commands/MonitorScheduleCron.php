<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\ScheduleModel;
use App\Models\SettingsModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MonitorScheduleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:shouldfinalize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finaliza cada agendamento realizado verificando caso o horário de fechamento do dia já passou.';

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

            $schedules = ScheduleModel::where('status', '!=', 'Finalizado')->get();
            $now = Carbon::now()->format('Y-m-d');

            foreach ($schedules as $schedule) {
                if (Carbon::parse($now)->diffInDays($schedule->date, false) <= 1 && now()->format('Y-m-d H:i') > Carbon::parse($schedule->date . ' ' . SettingsModel::first()->hora_fechamento)->subDays()->format('Y-m-d H:i')) {
                // if (Carbon::parse($now)->diffInDays($schedule->date, false) <= 1 && now()->format('H:i') >= SettingsModel::first()->hora_fechamento) {
                    $schedule->update([
                        'status' => 'Finalizado',
                        'finalizado_em' => now()->format('Y-m-d H:i:s')
                    ]);
                }        
            }

            DB::commit();
            
            $this->info('Horários atualizados com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
            $this->error('Ocorreu um erro ao atualizar os horários.');
        }
    }
}
