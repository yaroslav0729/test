<?php

namespace App\Console;

use App\Console\Commands\CancelSubscriptionsCreateAfter21April;
use App\Console\Commands\CancelSubscriptionsCreateBefore21April;
use App\Services\RamadanService;
use Carbon\Carbon;
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
        //
    ];

    protected function scheduleTimezone()
    {
        return 'Europe/London';
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $now = now();

        $schedule->command('clear:cart')->dailyAt('00:00');
        $schedule->command('icharm:send')->everyThirtyMinutes();
        $schedule->command(CancelSubscriptionsCreateBefore21April::class)->at('23:59')->when(function() use ($now) {
            return $now->toDateString() === Carbon::parse('2023-04-21')->toDateString();
        });
        $schedule->command(CancelSubscriptionsCreateAfter21April::class)->at('23:59')->when(function() use ($now) {
            return $now->toDateString() === Carbon::parse('2023-04-20')->toDateString();
        });
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
