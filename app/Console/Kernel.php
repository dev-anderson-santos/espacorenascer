<?php

namespace App\Console;

use App\Console\Commands\MonitorScheduleCron;
use App\Console\Commands\MonitorScheduleFaturarCron;
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
        $schedule->command('schedule:shouldfinalize')->twiceDaily(8, 12);
        $schedule->command('schedule:faturar')->monthly();
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
