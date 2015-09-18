<?php

namespace MkmScraper\Console\Commands;

use Illuminate\Console\Command;

class SaveBoosterAverage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saveboosteraverage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate our database for booster average prices';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(\MkmScraper\Set::all() as $set){
            \MkmScraper\BoosterAverage::create(array("low"=>$set->averageBoosterLow(),"trend"=>$set->averageBooster(),"id_set"=>$set->id));
        }
    }
}



