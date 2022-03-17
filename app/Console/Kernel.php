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
	    Commands\TweetBot::Class,
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
        $schedule->command('batch:TweetBot')
                    ->weekdays()
                    ->timezone('Asia/Tokyo')
                    ->twiceDaily(8, 16);

        $schedule->command('batch:TweetBot')
                    ->timezone('Asia/Tokyo')
                    ->twiceDaily(12, 23);

        $schedule->command('batch:TweetBot')
                    ->weekends()
                    ->everyThreeHours()
                    ->timezone('Asia/Tokyo')
                    ->between('0:00', '6:00');

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
