<?php

namespace MkmScraper\Console\Commands;

use Illuminate\Console\Command;

class ScrapePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrapeprices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape prices from MKM';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(\MkmScraper\Card::all() as $card){
            $product=queryMKMAPI("product/".$card->idProduct);
            $articles=queryMKMAPI("articles/".$card->idProduct);
            $price=$product->product->priceGuide;
            $cardPrice=\MkmScraper\CardPrice::create(array("id_card"=>$card->idProduct,"sell"=>$price->SELL,"low"=>$price->LOW,"lowex"=>$price->LOWEX,"lowfoil"=>$price->LOWFOIL,"avg"=>$price->AVG,"trend"=>$price->TREND,"sellers"=>sizeof($articles->article)));

        }
    }
}
