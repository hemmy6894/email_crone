<?php

namespace App\Console;

use App\Http\Controllers\EmailController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $email = new EmailController();
            $email->send();
        })->everyMinute()->name("SEND EMAIL EVERY MINUTES");

        $schedule->call(function () {
            $email = new EmailController();
            $email->jamaap();
        })->everyFiveMinutes()->name("GET JAMAAP EMAIL");

        $schedule->call(function () {
            $email = new EmailController();
            $email->skyland();
        })->everyFiveMinutes()->name("GET SKYLAND EMAIL");
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
