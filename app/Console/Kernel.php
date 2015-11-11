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
        \MkmScraper\Console\Commands\SaveBoosterAverage::class,
        \MkmScraper\Console\Commands\ScrapeGraph::class,
        \MkmScraper\Console\Commands\ExportSet::class,
        \MkmScraper\Console\Commands\ExportAll::class,
    ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('checkforitems')->daily();
        $schedule->command("scrapehtml")->everyThirtyMinutes();
        $schedule->command("saveboosteraverage")->dailyAt('16:00');
        $schedule->command("scrapegraph")->everyTenMinutes();

    }
}
