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
}
