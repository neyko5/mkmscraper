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
    $crawler = $client->request('GET','http://mtgtop8.com/event?e=10488');
    $link=$crawler->filter("td>div>div a")->each(function($node) use ($client){

        if(strpos($node->attr('href'),"event")!==false){
            print "http://mtgtop8.com/".$node->attr('href') ." - ".$node->text()."<br>";
            $dlcrawler=$client->request('GET',"http://mtgtop8.com/".$node->attr('href'));
            $link=$dlcrawler->filter("table table td .chosen_tr,table table td .hover_tr")->each(function($node){
                print "<b>".$node->text()."</b><br>";
            });
        }
    });


});

Route::get("htmlscrape",function(){
    $client = new \Goutte\Client();
    foreach(\MkmScraper\Card::all() as $card){
        $time=microtime();
        $crawler = $client->request('GET','https://www.magiccardmarket.eu/Products/Singles/'.rawurlencode($card->set).'/'.rawurlencode($card->name));
        $available=$crawler->filter('#ProductInformation script')->first()->text();
        $split=explode("chartData =",$available);
        $split2=explode(";var ctx",$split[1]);
        $object=json_decode($split2[0]);
        foreach($object->labels as $key=>$label){
            if(\MkmScraper\GraphPrice::where("id_card",$card->id)->where("date",date_format(date_create_from_format('d.m.y', $label), 'Y-m-d'))->count()<1){
                \MkmScraper\GraphPrice::create(array("id_card"=>$card->id,"date"=>date_format(date_create_from_format('d.m.y', $label), 'Y-m-d'),"sell"=>$object->datasets[0]->data[$key]));
            }
        }
        print $card->name. " - ".(microtime()-$time)." ms </br>";
    }

});

Route::get("decklists/wizards",function(){
    return view("decklists/wizards");
});

Route::post("decklists/wizards","ScrapeController@processWizards");

Route::get("decklists/scg",function(){
    return view("decklists/scg");
});

Route::post("decklists/scg","ScrapeController@processScg");

Route::get("decklists/top8",function(){
    return view("decklists/top8");
});

Route::post("decklists/top8","ScrapeController@processTop8");

Route::get("/","DisplayController@showSets");
Route::get("/set/{id}","DisplayController@showSet");
Route::get("/card/{id}","DisplayController@showCard");