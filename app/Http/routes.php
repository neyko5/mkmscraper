<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get("scrape",function(){
    foreach(\MkmScraper\Set::all() as $set){
        $articles=queryMKMAPI("articles/265721");
        dd(sizeof($articles->article));
        $result=queryMKMAPI("expansion/1/".rawurlencode($set->name));
        foreach($result->card as $key=>$card){

            $record=\MkmScraper\Card::find($card->idProduct);
            if(!$record){
                \MkmScraper\Card::create(array("id"=>$card->idProduct,"name"=>$card->name[0]->productName,"id_set"=>$set->id,"rarity"=>$card->rarity));
            }
            $product=queryMKMAPI("product/".$card->idProduct);


            $articles=queryMKMAPI("articles/".$card->idProduct);
            $price=$product->product->priceGuide;

            \MkmScraper\CardPrice::create(array("id_card"=>$card->idProduct,"sell"=>$price->SELL,"low"=>$price->LOW,"lowex"=>$price->LOWEX,"lowfoil"=>$price->LOWFOIL,"avg"=>$price->AVG,"trend"=>$price->TREND));
        }
    }
});