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
}
