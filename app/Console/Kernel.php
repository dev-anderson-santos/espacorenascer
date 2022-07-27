<?php

namespace App\Console;

use App\Console\Commands\MonitorScheduleCron;
use App\Console\Commands\MonitorScheduleFaturarCron;
use App\Console\Commands\MonitorScheduleMirrorCron;
use App\Console\Commands\ScheduleDeleteMirroredCron;
use App\Console\Commands\TesteCron;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        MonitorScheduleCron::class,
        MonitorScheduleFaturarCron::class,
        MonitorScheduleMirrorCron::class,
        ScheduleDeleteMirroredCron::class,
        TesteCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('ander:testecron')->daily();
        $schedule->command('schedule:shouldfinalize')->twiceDaily(8, 12);
        $schedule->command('schedule:faturar')->monthly();
        $schedule->command('schedule:mirror')->monthlyOn();
        $schedule->command('schedule:delete-mirrored')->monthlyOn(2, '0:01');
        // $schedule->command('schedule:shouldfinalize')->twiceDaily(8, 12);
        // $schedule->command('schedule:shouldfinalize')->twiceDaily(16, 20);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
