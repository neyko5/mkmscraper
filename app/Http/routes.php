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

});

Route::get("htmlscrape",function(){
    $client = new \Goutte\Client();
    foreach(\MkmScraper\Card::all() as $card){
        $crawler = $client->request('GET','https://www.magiccardmarket.eu/Products/Singles/'.rawurlencode($card->set).'/'.rawurlencode($card->name));
        $available=$crawler->filter('.sectioncontent .availTable .row_0  .cell_0_1')->first()->text();
        $low=$crawler->filter('.sectioncontent .availTable .row_1  .cell_1_1 span')->first()->text();
        $lowfinal=str_replace(",",".",$low);
        $trend=$crawler->filter('.sectioncontent .availTable .row_2  .cell_2_1')->first()->text();
        $trendnumber=explode(" ",$trend);
        $trendfinal=str_replace(",",".",$trendnumber[0]);
        $cardPrice=\MkmScraper\CardPrice::create(array("id_card"=>$card->id,"low"=>$low,"trend"=>$trendfinal,"sellers"=>$available));
    }
});