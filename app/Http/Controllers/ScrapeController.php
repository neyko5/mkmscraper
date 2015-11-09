<?php

namespace MkmScraper\Http\Controllers;

class ScrapeController extends Controller
{
    public function processWizards(){
        $event=\MkmScraper\Event::create(array("name"=>\Input::get("name"),"date"=>\Input::get("date"),"rank"=>\Input::get("rank"),"link"=>\Input::get("url")));
        for($i=1;$i<9;$i++){
            if(\Input::get("url_".$i)){
                if (($handle = fopen(\Input::get("url_".$i), "r")) !== FALSE) {
                    while (($data = fgets($handle,1000))!== FALSE) {
                        $split=explode(" ",$data,2);
                        if(sizeof($split)>1){
                            $card=\MkmScraper\Card::where("name",trim($split[1]))->first();
                            if($card){
                                \MkmScraper\DecklistAppearance::create(array("id_card"=>$card->id,"number"=>$split[0],"id_event"=>$event->id,"place"=>$i));
                            }
                        }
                    }
                }
            }
        }
        return redirect("decklists/wizards")->with(array("message"=>"Decklists from tournament <b>".\Input::get("name")."</b> was successfully entered."));
    }

    public function processScg(){
        $client = new \Goutte\Client();
        $crawler = $client->request('GET',\Input::get("url"));
        $event=\MkmScraper\Event::create(array("name"=>\Input::get("name"),"date"=>\Input::get("date"),"rank"=>\Input::get("rank"),"link"=>\Input::get("url")));
        $link=$crawler->filter("td a")->each(function($node) use ($client,$event){
            if(strpos($node->attr('href'),"http://sales.starcitygames.com//deckdatabase/displaydeck.php?DeckID=")!==false){
                $dlcrawler=$client->request('GET',$node->attr('href'));
                $place=explode(" ",$dlcrawler->filter(".deck_played_placed")->first()->text());
                $numberplace=intval($place[0]);
                print "<i>".$numberplace."</i>";
                $link=$dlcrawler->filter(".deck_card_wrapper li")->each(function($node) use($numberplace,$event){
                    $split=explode(" ",$node->text(), 2);
                    $card=\MkmScraper\Card::where("name",$split[1])->first();
                    if($card){
                        \MkmScraper\DecklistAppearance::create(array("id_card"=>$card->id,"number"=>$split[0],"place"=>$numberplace,"id_event"=>$event->id));
                        print $card->id." - ".$node->text()."<br/>";
                    }
                });
            }
        });
        return redirect("decklists/scg")->with(array("message"=>"Decklists from tournament <b>".\Input::get("name")."</b> was successfully entered."));
    }

    public function processTop8(){
        $client = new \Goutte\Client();
        $crawler = $client->request('GET',\Input::get("url"));
        $event=\MkmScraper\Event::create(array("name"=>\Input::get("name"),"date"=>\Input::get("date"),"rank"=>\Input::get("rank"),"link"=>\Input::get("url")));
        $i=1;
        $link=$crawler->filter("td>div>div a")->each(function($node) use ($client,$event,&$i){

            if(strpos($node->attr('href'),"event")!==false){
                $dlcrawler=$client->request('GET',$node->attr('href'));
                $link=$dlcrawler->filter("table table td .chosen_tr,table table td .hover_tr")->each(function($node) use($event,$i){
                    $split=explode(" ",$node->text(), 2);
                    $card=\MkmScraper\Card::where("name",$split[1])->first();
                    if($card){
                        \MkmScraper\DecklistAppearance::create(array("id_card"=>$card->id,"number"=>$split[0],"place"=>$i,"id_event"=>$event->id));
                        //print $card->id." - ".$node->text()."<br/>";
                    }
                });
                $i=$i+1;
            }
        });
        return redirect("decklists/top8")->with(array("message"=>"Decklists from tournament <b>".\Input::get("name")."</b> was successfully entered."));
    }
}
