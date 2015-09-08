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
        foreach(\MkmScraper\Set::all() as $set){
            $result=queryMKMAPI("expansion/1/".rawurlencode($set->name));
            foreach($result->card as $card){
                $record=\MkmScraper\Card::find($card->idProduct);
                if(!$record){
                    \MkmScraper\Card::create(array("id"=>$card->idProduct,"name"=>$card->name[0]->productName,"id_set"=>$set->id,"rarity"=>$card->rarity));
                }
                $product=queryMKMAPI("product/".$card->idProduct);
                $price=$product->product->priceGuide;
                \MkmScraper\CardPrice::create(array("id_card"=>$card->idProduct,"sell"=>$price->SELL,"low"=>$price->LOW,"lowex"=>$price->LOWEX,"lowfoil"=>$price->LOWFOIL,"avg"=>$price->AVG,"trend"=>$price->TREND));
            }
        }
    }
}
