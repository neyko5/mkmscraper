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
        foreach(\MkmScraper\CardPrice::where("id_card",$this->id)->orderBy("updated_at","ASC")->get() as $price){
            $date=explode("-",date("Y-m-d",strtotime($price->created_at)));
            $objects['low'][] = array($date[0], $date[1],$date[2],$price->priceDiff());
        }
        foreach(\MkmScraper\GraphPrice::where("id_card",$this->id)->orderBy("date","ASC")->get() as $price){
            $date=explode("-",$price->date);
            $objects['art'][] = array($date[0], $date[1],$date[2],$price->tournamentDiffWeek());
        }
        return json_encode($objects);
    }

    public function graphPrices(){
        return $this->hasMany("\MkmScraper\GraphPrice","id_card");
    }

    public function tournamentPercentage(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id)->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        return round(100*$card/$all,3);
    }

    public function tournamentLastWeek(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d'))->where("events.date",">=",date('Y-m-d', strtotime('-7 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id)->where("events.date","<",date('Y-m-d'))->where("events.date",">=",date('Y-m-d', strtotime('-7 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        return round(100*$card/$all,3);
    }

    public function tournamentLastTwoWeek(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime('-7 days')))->where("events.date",">=",date('Y-m-d', strtotime('-14 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id)->where("events.date","<",date('Y-m-d', strtotime('-7 days')))->where("events.date",">=",date('Y-m-d', strtotime('-14 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        return round(100*$card/$all,3);
    }

    public function tournamentLastThreeWeek(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime('-14 days')))->where("events.date",">=",date('Y-m-d', strtotime('-21 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id)->where("events.date","<",date('Y-m-d', strtotime('-14 days')))->where("events.date",">=",date('Y-m-d', strtotime('-21 days')))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        return round(100*$card/$all,3);
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


}
