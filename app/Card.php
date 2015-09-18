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

        $firstPrice=\MkmScraper\CardPrice::orderBy("updated_at","ASC")->first();
        $objects=array("trend"=>array());
        for($year=intval(date("Y"));$year>=intval(date("Y",strtotime($firstPrice->updated_at)));$year--){
            for($month=12;$month>=1;$month--){
                for($day=31;$day>=1;$day--){
                    if(($year."-".sprintf('%02d', $month)."-".sprintf('%02d', $month)." 00:00:00")<date("Y-m-d h:i:s")) {
                        $start = $year . "-" . sprintf('%02d', $month) . "-".sprintf('%02d', $day)." 00:00:00";
                        $end = $year . "-" . sprintf('%02d', $month) . "-".sprintf('%02d', $day)." 23:59:59";

                        $cardPrice=\MkmScraper\CardPrice::where("id_card",$this->id)->where("updated_at", ">", $start)->where("updated_at", "<", $end)->first();
                        if($cardPrice){
                            $objects['trend'][] = array($year, $month,$day,$cardPrice->trend);
                            //$objects['low'][] = array($year, $month,$day, $cardPrice->low);
                        }



                    }
                }
            }
        }
        return json_encode($objects);
    }

    public function getSecondChart(){

        $firstPrice=\MkmScraper\GraphPrice::orderBy("date","ASC")->first();
        $objects=array("trend"=>array());
        for($year=intval(date("Y"));$year>=intval(date("Y",strtotime($firstPrice->updated_at)));$year--){
            for($month=12;$month>=1;$month--){
                for($day=31;$day>=1;$day--){
                    if(($year."-".sprintf('%02d', $month)."-".sprintf('%02d', $month)." 00:00:00")<date("Y-m-d h:i:s")) {
                        $start = $year . "-" . sprintf('%02d', $month) . "-".sprintf('%02d', $day);
                        $end = $year . "-" . sprintf('%02d', $month) . "-".sprintf('%02d', $day);

                        $cardPrice=\MkmScraper\GraphPrice::where("id_card",$this->id)->where("date", ">", $start)->where("date", "<", $end)->first();
                        if($cardPrice){
                            $objects['sell'][] = array($year, $month,$day,$cardPrice->sell);
                            //$objects['low'][] = array($year, $month,$day, $cardPrice->low);
                        }



                    }
                }
            }
        }
        return json_encode($objects);
    }

}
