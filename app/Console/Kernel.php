<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SetUserAsAdmin;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SetUserAsAdmin::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('check:payment-dues')->daily();
    }
}
