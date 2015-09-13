<?php

namespace MkmScraper\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \MkmScraper\Console\Commands\ScrapePrices::class,
    ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('scrapeprices')->hourly();
    }
}
