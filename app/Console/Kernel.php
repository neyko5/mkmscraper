<?php

namespace MkmScraper\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \MkmScraper\Console\Commands\ScrapePrices::class,
        \MkmScraper\Console\Commands\CheckForItems::class,
        \MkmScraper\Console\Commands\ScrapeHtml::class,
    ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('scrapeprices')->daily();
        $schedule->command('checkforitems')->daily();
        $schedule->command('scrapehtml')->daily();
    }
}
