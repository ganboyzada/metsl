<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RunQueueWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-queue-worker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting the queue worker...');

        $process = Process::fromShellCommandline('php artisan queue:work', base_path());
        $process->setTimeout(null);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
