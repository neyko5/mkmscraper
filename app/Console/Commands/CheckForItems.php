<?php

namespace MkmScraper\Console\Commands;

use Illuminate\Console\Command;

class CheckForItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkforitems';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for new items on MKM';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        foreach(\MkmScraper\Set::all() as $set){
            $result=queryMKMAPI("expansion/1/".rawurlencode($set->name));
            foreach($result->card as $card){
                $record=\MkmScraper\Card::find($card->idProduct);
                if(!$record){
                    \MkmScraper\Card::create(array("id"=>$card->idProduct,"name"=>$card->name[0]->productName,"id_set"=>$set->id,"rarity"=>$card->rarity));
                }
            }

        }
    }
}