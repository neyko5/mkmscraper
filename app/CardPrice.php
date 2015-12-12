<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class CardPrice extends Model
{
    protected $fillable=array("id_card","sell","low","lowex","lowfoil","avg","trend","sellers");

    public function priceDiff(){
        $lastDay=\DB::table("card_prices")->where("id_card",$this->id_card)->where("created_at",">",date('Y-m-d 00:00:00', strtotime($this->created_at)-24*60*60))->where("created_at",">",date('Y-m-d 00:00:00', strtotime($this->created_at)-24*60*60))->select('low')->first();
        if($lastDay){
            return $this->low-$lastDay->low;
        }
        else{
            return -1;
        }
    }

    public static function getPriceWeek($date,$card){
        $resultThis=\DB::table("card_prices")->where("id_card",$card->id)->where("created_at",">",date('Y-m-d  00:00:00',strtotime($date)-7*24*60*60))->where("created_at",">=",$date.' 23:59:59')->avg("low");
        return $resultThis;
    }

    public static function getItemsWeek($date,$card){
        $resultThis=\DB::table("card_prices")->where("id_card",$card->id)->where("created_at",">",date('Y-m-d  00:00:00',strtotime($date)-7*24*60*60))->where("created_at",">=",$date.' 23:59:59')->avg("sellers");
        return $resultThis;
    }

    public static function getPriceDiffWeek($date,$card){
        $resultThis=\DB::table("card_prices")->where("id_card",$card->id)->where("created_at",">",date('Y-m-d  00:00:00',strtotime($date)-7*24*60*60))->where("created_at",">=",$date.' 23:59:59')->avg("low");
        $resultLast=\DB::table("card_prices")->where("id_card",$card->id)->where("created_at",">",date('Y-m-d  00:00:00',strtotime($date)-14*24*60*60))->where("created_at",">=",date('Y-m-d  00:00:00',strtotime($date)-7*24*60*60).' 23:59:59')->avg("low");
        return $resultThis-$resultLast;
    }

    public static function getPriceSingleWeek($date,$card){
        $resultThis=\DB::table("card_prices")->where("id_card",$card->id)->where("created_at","<",date('Y-m-d  23:59:59',strtotime($date)))->where("created_at",">=",date('Y-m-d  00:00:00',strtotime($date)-4*24*60*60))->avg("low");
        $resultLast=\DB::table("card_prices")->where("id_card",$card->id)->where("created_at",">",date('Y-m-d  00:00:00',strtotime($date)-4*24*60*60))->where("created_at","<=",date("Y-m-d 23:59:59",strtotime($date)-7*24*60*60))->avg("low");
        return $resultThis-$resultLast;
    }

    public static function getPriceSingleWeekHalf($date,$card){
        $resultThis=\DB::table("card_prices")->where("id_card",$card->id)->where("created_at","<",date('Y-m-d  23:59:59',strtotime($date)))->where("created_at",">=",date('Y-m-d  00:00:00',strtotime($date)-1*24*60*60))->avg("low");
        $resultLast=\DB::table("card_prices")->where("id_card",$card->id)->where("created_at","<",date('Y-m-d  23:59:59',strtotime($date)-6*24*60*60))->where("created_at",">=",date("Y-m-d 00:00:00",strtotime($date)-7*24*60*60))->avg("low");
        return $resultThis-$resultLast;
    }

    public static function getItemsSingleWeek($date,$card){
        $resultThis=\DB::table("card_prices")->where("id_card",$card->id)->where("created_at",">",date('Y-m-d  00:00:00',strtotime($date)))->where("created_at","<=",$date.' 23:59:59')->avg("sellers");
        $resultLast=\DB::table("card_prices")->where("id_card",$card->id)->where("created_at",">",date('Y-m-d  00:00:00',strtotime($date)-7*24*60*60))->where("created_at","<=",date("Y-m-d 23:59:59",strtotime($date)-7*24*60*60))->avg("sellers");
        return $resultThis-$resultLast;
    }
}
