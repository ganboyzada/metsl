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
        \App\Console\Commands\RunQueueWorker::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
                 
        $schedule->command('app:run-queue-worker')->everyMinute();
      //  if (stripos((string) shell_exec('ps xf | grep \'[q]ueue:work\''), 'artisan queue:work') === false) {
           // $schedule->command('queue:work --once')->everyMinute()->appendOutputTo(storage_path('logs/scheduler.log'));
       // }             
					 
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
