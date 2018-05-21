<?php

namespace App\Console;

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
        Commands\ServerSocket::class,
        Commands\QueueMonitor::class,
        Commands\DataProcessor::class,
        Commands\PurgeOldData::class,
        Commands\GenerateItemsDB::class,
        Commands\ChargeActiveSubscribers::class,
        Commands\CancelForNonPayment::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        //$schedule->command('custom:chargeactivesubscribers')->monthlyOn(1, '0:01');
        //$schedule->command('custom:cancelfornonpayment')->dailyAt('0:05');
        $schedule->command('custom:purgeolddata')->everyMinute();
        //$schedule->command('queuemonitor:start')->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
