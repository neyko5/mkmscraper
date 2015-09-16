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
    $client = new \Goutte\Client();
    $crawler = $client->request('GET','http://sales.starcitygames.com/deckdatabase/deckshow.php?event_ID=45&t[T3]=1&start_date=2015-09-05&end_date=2015-09-06&order_1=finish&limit=100&action=Show+Decks&city=Cincinnati');
    $link=$crawler->filter("td a")->each(function($node) use ($client){
        if(strpos($node->attr('href'),"http://sales.starcitygames.com//deckdatabase/displaydeck.php?DeckID=")!==false){
            $dlcrawler=$client->request('GET',$node->attr('href'));
            $place=explode(" ",$dlcrawler->filter(".deck_played_placed")->first()->text());
            $numberplace=intval($place[0]);
            print "<i>".$numberplace."</i>";
            $link=$dlcrawler->filter(".deck_card_wrapper li")->each(function($node) use($numberplace){
                $split=explode(" ",$node->text(), 2);
                $card=\MkmScraper\Card::where("name",$split[1])->first();
                if($card){
                    \MkmScraper\DecklistAppearance::create(array("id_card"=>$card->id,"number"=>$split[0],"rank"=>"3","place"=>$numberplace,"date"=>"2015-01-02"));
                    print $card->id." - ".$node->text()."<br/>";
                }
            });
        }
    });


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

Route::get("decklists/wizards",function(){
    return view("scrape/wizards");
});

Route::post("decklists/wizards","ScrapeController@processWizards");
