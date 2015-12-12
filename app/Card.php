<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public $timestamps=false;
    protected $fillable=array("id","name","id_set","rarity");

    public function set(){
        return $this->belongsTo("\MkmScraper\Set","id_set");
    }

    public function prices(){
        return $this->hasMany("\MkmScraper\CardPrice","id_card");
    }
    
    public function todaysPrice(){
        return $this->prices()->where("updated_at","<",date("Y-m-d")." 23:59:59")->where("updated_at",">",date("Y-m-d")." 00:00:00");
    }

    public function lastPrice(){
        return $this->prices()->orderBy("updated_at","DESC")->first();
    }

    public function getChart(){
        $objects=array("trend"=>array(),"sell"=>array(),"low"=>array());
        foreach(\MkmScraper\CardPrice::where("id_card",$this->id)->orderBy("updated_at","ASC")->get() as $price){
            $date=explode("-",date("Y-m-d",strtotime($price->created_at)));
            $objects['trend'][] = array($date[0], $date[1],$date[2],$price->trend);
            $objects['low'][] = array($date[0], $date[1],$date[2],$price->low);
            $objects['sellers'][] = array($date[0], $date[1],$date[2],$price->sellers);
        }
        foreach(\MkmScraper\GraphPrice::where("id_card",$this->id)->orderBy("date","ASC")->get() as $price){
            $date=explode("-",$price->date);
            $objects['sell'][] = array($date[0], $date[1],$date[2],$price->sell);
        }

        return json_encode($objects);
    }

    public function getMovement(){
        $date="2015-09-03";
        $objects=array();
        while($date<"2015-12-10"){
            $dateexp=explode("-",$date);
            //$objects['sell'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\CardPrice::getPriceSingleWeek($date,$this));
            //$objects['sell'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\GraphPrice::getPriceWeek($date,$this));
            $objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getArticlesWeek(date("Y-m-d",strtotime($date)+7*24*60*60),$this));
            //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getArticlesWeek(date("Y-m-d",strtotime($date)-0*24*60*60),$this)*\MkmScraper\Article::getDiffWeek(date("Y-m-d",strtotime($date)-0*24*60*60),$this));
            //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getArticlesWeek(date("Y-m-d",strtotime($date)+7*24*60*60),$this));
            //$objects['items'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\CardPrice::getItemsSingleWeek(date("Y-m-d",strtotime($date)+14*24*60*60),$this));
            //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getArticlesTwoWeek($date,$this));
            //$objects['sell'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\GraphPrice::getPriceDiffWeek($date,$this));
            //$objects['sell'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\GraphPrice::getPriceSingleWeekBoolean($date,$this));
            //$objects['sell2'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\GraphPrice::getPriceSingleWeek($date,$this));
            $objects['sell1'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\GraphPrice::getPriceSingleWeekHalf($date,$this));
            //$objects['oth'][]=array($dateexp[0], $dateexp[1],$dateexp[2],-\MkmScraper\GraphPrice::getPriceOtherSingleWeek(date("Y-m-d",strtotime($date)-7*24*60*60),$this));
            //$objects['sell'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\CardPrice::getPriceDiffWeek($date,$this));
            //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getDiffWeek(date("Y-m-d",strtotime($date)-1*24*60*60),$this)*1+\MkmScraper\Article::getDiffWeek(date("Y-m-d",strtotime($date)-7*24*60*60),$this)*3+\MkmScraper\Article::getDiffWeek(date("Y-m-d",strtotime($date)-14*24*60*60),$this)*1);
            //$objects['art1'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getDiffWeek(date("Y-m-d",strtotime($date)+14*24*60*60),$this));
            //$objects['art2'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getDiffWeek(date("Y-m-d",strtotime($date)+14*24*60*60),$this));
            //$objects['art3'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getDiffWeek(date("Y-m-d",strtotime($date)-14*24*60*60),$this));
            //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getDiffWeekBoolean(date("Y-m-d",strtotime($date)-7*24*60*60),$this));
            //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getDiffTwoWeek($date,$this));
            //$objects['touryes'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\DecklistAppearance::tournamentLastWeek(date("Y-m-d",strtotime($date)+7*24*60*60),$this));
            //$objects['tour'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\DecklistAppearance::tournamentDiffLastWeek(date("Y-m-d",strtotime($date)-14*24*60*60),$this));
            //$objects['tour2'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\DecklistAppearance::tournamentDiffLastWeek(date("Y-m-d",strtotime($date)-7*24*60*60),$this));
            //$objects['tour3'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\DecklistAppearance::tournamentDiffLastWeek(date("Y-m-d",strtotime($date)-14*24*60*60),$this));
            //$objects['tour3'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\DecklistAppearance::tournamentDiffLastWeek(date("Y-m-d",strtotime($date)+0*24*60*60),$this));
            //$objects['tour'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\DecklistAppearance::tournamentDiffLastWeekBoolean(date("Y-m-d",strtotime($date)-14*24*60*60),$this));
            $date=date("Y-m-d",strtotime($date)+7*24*60*60);
        }
        /*foreach(\MkmScraper\CardPrice::where("id_card",$this->id)->orderBy("updated_at","ASC")->get() as $price){
            $date=explode("-",date("Y-m-d",strtotime($price->created_at)));
            $objects['low'][] = array($date[0], $date[1],$date[2],$price->priceDiff());
        }
        foreach(\MkmScraper\GraphPrice::where("id_card",$this->id)->orderBy("date","ASC")->get() as $price){
            $date=explode("-",$price->date);
            $objects['art'][] = array($date[0], $date[1],$date[2],$price->tournamentDiffWeek());
        }*/
        return json_encode($objects);
    }

    public function getMovementData(){
        $date="2015-09-03";
        $objects=array();
        while($date<"2015-12-10"){
            //$object['sell']=\MkmScraper\CardPrice::getPriceWeek($date,$this);
            $object['price']=\MkmScraper\GraphPrice::getPriceWeek($date,$this);
            $object['lowprice']=\MkmScraper\CardPrice::getPriceWeek($date,$this);
            $object['singleprice']=\MkmScraper\GraphPrice::getPriceSingleWeek($date,$this);
            $object['lowsingleprice']=\MkmScraper\CardPrice::getPriceSingleWeek($date,$this);
            //$object['art']=\MkmScraper\Article::getArticlesWeek($date,$this);
            //$object['art']=\MkmScraper\Article::getArticlesWeek(date("Y-m-d",strtotime($date)+6*24*60*60),$this);
            //$object['art']=\MkmScraper\Article::getArticlesTwoWeek($date,$this);
            $object['sell']=\MkmScraper\GraphPrice::getPriceDiffWeek($date,$this);
            $object['date']=$date;
            //$object['sell']=\MkmScraper\CardPrice::getPriceDiffWeek($date,$this);
            //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getDiffWeek($date,$this));
            $object['arttot']=\MkmScraper\Article::getArticlesWeek($date,$this);
            $object['art']=\MkmScraper\Article::getDiffWeek($date,$this);
            $object['tour']=\MkmScraper\DecklistAppearance::tournamentLastWeek($date,$this);
            $object['tourdiff']=\MkmScraper\DecklistAppearance::tournamentDiffLastWeek(date("Y-m-d",strtotime($date)-14*24*60*60),$this);
            $date=date("Y-m-d",strtotime($date)+7*24*60*60);
            $objects[]=$object;
        }
        return $objects;
    }

    public function graphPrices(){
        return $this->hasMany("\MkmScraper\GraphPrice","id_card");
    }

    public function tournamentPercentage(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id)->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        if($all>0){
            return round(100*$card/$all,3);
        }
        else{
            return 0;
        }
    }

    public function tournamentLastWeek(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d'))->where("events.date",">=",date('Y-m-d', strtotime('-7 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id)->where("events.date","<",date('Y-m-d'))->where("events.date",">=",date('Y-m-d', strtotime('-7 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        if($all>0){
            return round(100*$card/$all,3);
        }
        else{
            return 0;
        }

    }

    public function tournamentLastTwoWeek(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime('-7 days')))->where("events.date",">=",date('Y-m-d', strtotime('-14 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id)->where("events.date","<",date('Y-m-d', strtotime('-7 days')))->where("events.date",">=",date('Y-m-d', strtotime('-14 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        if($all>0){
            return round(100*$card/$all,3);
        }
        else{
            return 0;
        }
    }

    public function tournamentLastThreeWeek(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime('-14 days')))->where("events.date",">=",date('Y-m-d', strtotime('-21 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id)->where("events.date","<",date('Y-m-d', strtotime('-14 days')))->where("events.date",">=",date('Y-m-d', strtotime('-21 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        if($all>0){
            return round(100*$card/$all,3);
        }
        else{
            return 0;
        }
    }

    public function articles(){
        $result=\DB::table("articles")->where("text","LIKE","%".$this->name."%")->sum(\DB::raw("(5-articles.popularity)"));
        return $result;
    }

    public function articlesLastWeek(){
        $result=\DB::table("articles")->where("text","LIKE","%".$this->name."%")->where("articles.date","<",date('Y-m-d'))->where("articles.date",">=",date('Y-m-d', strtotime('-7 days')))->sum(\DB::raw("(5-articles.popularity)"));
        return $result;
    }

    public function articlesLastTwoWeek(){
        $result=\DB::table("articles")->where("text","LIKE","%".$this->name."%")->where("articles.date","<",date('Y-m-d', strtotime('-7 days')))->where("articles.date",">=",date('Y-m-d', strtotime('-14 days')))->sum(\DB::raw("(5-articles.popularity)"));
        return $result;
    }

    public function articlesLastThreeWeek(){
        $result=\DB::table("articles")->where("text","LIKE","%".$this->name."%")->where("articles.date","<",date('Y-m-d', strtotime('-14 days')))->where("articles.date",">=",date('Y-m-d', strtotime('-21 days')))->sum(\DB::raw("(5-articles.popularity)"));
        return $result;
    }

    public function decklistAppearances(){
        return $this->hasMany("\MkmScraper\DecklistAppearance","id_card");
    }

    public function distanceFromRotation($date){
        return $this->set->daysFromRotationDate($date);
    }

    public function distanceFromRotationExp($date){
        $dist=$this->distanceFromRotation(date("Y-m-d",strtotime($date)+14*24*60*60));
        if($dist>0){
            return round(1/pow(pow(M_E,$dist),0.2),3);
        }
        else{
            return 0;
        }

    }

    public function daysFromRelease($date){
        return $this->set->daysFromReleaseDate($date);
    }

    public function distanceFromReleaseExp($date){
        $dist=$this->daysFromRelease(date("Y-m-d",strtotime($date)+14*24*60*60));
        if($dist>0){
            return round(1/pow(pow(M_E,$dist),0.2),3);
        }
        else{
            return 0;
        }

    }



}
