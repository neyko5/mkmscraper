<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class GraphPrice extends Model
{
    protected $fillable=array("id_card","sell","date");

    public function card(){
        return $this->belongsTo("\MkmScraper\Card","id_card");
    }

    public function priceDiff(){
        $lastDay=\DB::table("graph_prices")->where("id_card",$this->id_card)->where("date","=",date('Y-m-d', strtotime($this->date)-24*60*60))->select('sell')->first();
        if($lastDay){
            return $this->sell-$lastDay->sell;
        }
        else{
            return -1;
        }
    }

    public function priceClass(){
        $lastDay=\DB::table("graph_prices")->where("id_card",$this->id_card)->where("date","=",date('Y-m-d', strtotime($this->date)-7*24*60*60))->select('sell')->first();
        if($lastDay &&  ($this->sell-$lastDay->sell)>=0){
            return 1;
        }
        else{
            return -1;
        }
    }


    public function tournamentPercentage(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id_card)->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        if($all>0){
            return round(100*$card/$all,3);
        }
        else{
            return 0;
        }
    }

    public function tournamentLastWeek(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime($this->date)))->where("events.date",">=",date('Y-m-d', strtotime($this->date)-7*24*60*60))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id_card)->where("events.date","<",date('Y-m-d', strtotime($this->date)))->where("events.date",">=",date('Y-m-d', strtotime($this->date)-7*24*60*60))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        if($all>0){
            return round(100*$card/$all,3);
        }
        else{
            return 0;
        }
    }

    public function tournamentLastTwoWeek(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime($this->date)-7*24*60*60))->where("events.date",">=",date('Y-m-d', strtotime($this->date)-14*24*60*60))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id_card)->where("events.date","<",date('Y-m-d', strtotime($this->date)-7*24*60*60))->where("events.date",">=",date('Y-m-d', strtotime($this->date)-14*24*60*60))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        if($all>0){
            return round(100*$card/$all,3);
        }
        else{
            return 0;
        }

    }

    public function tournamentLastThreeWeek(){
        $all=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime($this->date)-14*24*60*60))->where("events.date",">=",date('Y-m-d', strtotime($this->date)-21*24*60*60))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        $card=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$this->id_card)->where("events.date","<",date('Y-m-d', strtotime($this->date)-14*24*60*60))->where("events.date",">=",date('Y-m-d', strtotime($this->date)-21*24*60*60))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)"));
        if($all>0){
            return round(100*$card/$all,3);
        }
        else{
            return 0;
        }
    }

    public function tournamentDiffWeek(){
        return  $this->tournamentLastWeek()- $this->tournamentLastTwoWeek();
    }

    public function tournamentDiffTwoWeek(){
        return  $this->tournamentLastTwoWeek()- $this->tournamentLastThreeWeek();
    }

    public function articles(){
        $result=\DB::table("articles")->where("text","LIKE","%".$this->card->name."%")->sum(\DB::raw("(5-articles.popularity)"));
        return $result;
    }

    public function articlesLastWeek(){
        $result=\DB::table("articles")->where("text","LIKE","%".$this->card->name."%")->where("articles.date","<",$this->date)->where("articles.date",">=",date('Y-m-d', strtotime($this->date)-7*24*60*60))->sum(\DB::raw("(5-articles.popularity)"));
        return $result;
    }

    public function articlesLastTwoWeek(){
        $result=\DB::table("articles")->where("text","LIKE","%".$this->card->name."%")->where("articles.date","<",date('Y-m-d', strtotime($this->date)-7*24*60*60))->where("articles.date",">=",date('Y-m-d', strtotime($this->date)-14*24*60*60))->sum(\DB::raw("(5-articles.popularity)"));
        return $result;
    }

    public function articlesLastThreeWeek(){
        $result=\DB::table("articles")->where("text","LIKE","%".$this->card->name."%")->where("articles.date","<",date('Y-m-d', strtotime($this->date)-14*24*60*60))->where("articles.date",">=",date('Y-m-d', strtotime($this->date)-21*24*60*60))->sum(\DB::raw("(5-articles.popularity)"));
        return $result;
    }

    public function articlesDiffLastWeek(){
        return  $this->articlesLastWeek()- $this->articlesLastTwoWeek();
    }

    public function articlesDiffLastTwoWeek(){
        return  $this->articlesLastTwoWeek()- $this->articlesLastThreeWeek();
    }

    public function otherCardMovementDay(){
        $yesterday=\DB::table("graph_prices")->join('cards','cards.id',"=","graph_prices.id_card")->join('sets','sets.id',"=","cards.id_set")->where("date",date("Y-m-d",strtotime($this->date)-1*24*60*60))->where("cards.id","<>",$this->id)->sum('sell');
        $twodaysago=\DB::table("graph_prices")->join('cards','cards.id',"=","graph_prices.id_card")->join('sets','sets.id',"=","cards.id_set")->where("date",date("Y-m-d",strtotime($this->date)-2*24*60*60))->where("cards.id","<>",$this->id)->sum('sell');

        return $yesterday-$twodaysago;
    }
    public function otherCardMovementWeek(){
        $yesterday=\DB::table("graph_prices")->join('cards','cards.id',"=","graph_prices.id_card")->join('sets','sets.id',"=","cards.id_set")->where("date",date("Y-m-d",strtotime($this->date)-1*24*60*60))->where("cards.id","<>",$this->id)->sum('sell');
        $twodaysago=\DB::table("graph_prices")->join('cards','cards.id',"=","graph_prices.id_card")->join('sets','sets.id',"=","cards.id_set")->where("date",date("Y-m-d",strtotime($this->date)-7*24*60*60))->where("cards.id","<>",$this->id)->sum('sell');

        return $yesterday-$twodaysago;
    }
    public static function boostersOpen($date){
        $result=\DB::table("limited_seasons")->where("limited_seasons.start",">=",$date)->where("limited_seasons.end","<=",$date)->sum("number");
        return $result;
    }

    public static function pptqSeason($date){
        $result=\DB::table("pptq_seasons")->where("pptq_seasons.start",">=",$date)->where("pptq_seasons.end","<=",$date)->count("id");
        return $result;
    }

    public static function tournamentsNextWeekend($date){
        $result=\DB::table("events")->where("events.date",">=",$date)->where("events.date","<=",date('Y-m-d', strtotime($date)+7*24*60*60))->sum("rank");
        return $result;
    }

    public static function getPriceDiffWeek($date,$card){
        $resultThis=\DB::table("graph_prices")->where("id_card",$card->id)->where("graph_prices.date","<",$date)->where("graph_prices.date",">=",date('Y-m-d', strtotime($date)-7*24*60*60))->avg("sell");
        $resultLast=\DB::table("graph_prices")->where("id_card",$card->id)->where("graph_prices.date","<",date('Y-m-d', strtotime($date)-7*24*60*60))->where("graph_prices.date",">=",date('Y-m-d', strtotime($date)-14*24*60*60))->avg("sell");
        return $resultThis-$resultLast;
    }

    public static function getPriceDiffWeekBoolean($date,$card){
        return \Mkmscraper\GraphPrice::getPriceDiffWeek($date,$card)>0?"A":"B";
    }

    public static function getPriceWeek($date,$card){
        $resultThis=\DB::table("graph_prices")->where("id_card",$card->id)->where("graph_prices.date","<",$date)->where("graph_prices.date",">=",date('Y-m-d', strtotime($date)-7*24*60*60))->avg("sell");
        return $resultThis;
    }

    public static function getPriceSingleWeek($date,$card){
        $resultThis=\DB::table("graph_prices")->where("id_card",$card->id)->where("graph_prices.date","=",$date)->avg("sell");
        $resultThen=\DB::table("graph_prices")->where("id_card",$card->id)->where("graph_prices.date","=",date('Y-m-d', strtotime($date)-7*24*60*60))->avg("sell");
        return $resultThis-$resultThen;
    }
    public static function getPriceSingleWeekHalf($date,$card){
        $resultThis=\DB::table("graph_prices")->where("id_card",$card->id)->where("graph_prices.date","<=",$date)->where("graph_prices.date",">",date('Y-m-d', strtotime($date)-1*24*60*60))->avg("sell");
        $resultThen=\DB::table("graph_prices")->where("id_card",$card->id)->where("graph_prices.date","<=",date('Y-m-d', strtotime($date)-6*24*60*60))->where("graph_prices.date",">",date('Y-m-d', strtotime($date)-7*24*60*60))->avg("sell");
        return $resultThis-$resultThen;
    }

    public static function getPriceOtherSingleWeek($date,$card){
        $resultThis=\DB::table("graph_prices")->join('cards','cards.id',"=","graph_prices.id_card")->where("cards.id_set","=",$card->id_set)->where("id_card","<>",$card->id)->where("graph_prices.date","=",$date)->avg("sell");
        $resultThen=\DB::table("graph_prices")->join('cards','cards.id',"=","graph_prices.id_card")->where("cards.id_set","=",$card->id_set)->where("id_card","<>",$card->id)->where("graph_prices.date","=",date('Y-m-d', strtotime($date)-7*24*60*60))->avg("sell");
        return $resultThis-$resultThen;
    }

    public static function getPriceSingleWeekBoolean($date,$card){
        return GraphPrice::getPriceSingleWeek($date,$card)>0?"1":"-1";
    }

}
