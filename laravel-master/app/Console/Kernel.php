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
        // Commands\Inspire::class,
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
    	$schedule->call(function () {
    		app('App\Http\Controllers\NFLController')->fillCote();
    		app('App\Http\Controllers\NFLController')->fillPlayOffs();
    	})->daily()->at('02:00');
    	$schedule->call(function () {
    		ini_set('max_execution_time', 0);
    		app('App\Http\Controllers\NFLController')->fillMatch();
    		ini_set('max_execution_time', 3000);
    	})->weekly()->mondays()->at('02:00');
    }
}
