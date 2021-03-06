<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    public function __toString(){
        return $this->name;
    }

    public function cards(){
        return $this->hasMany("\MkmScraper\Card","id_set");
    }

    public function mythics(){
        return $this->hasMany("\MkmScraper\Card","id_set")->where("rarity","Mythic");
    }

    public function averageBooster(){
        $average=0;
        foreach($this->cards as $card){
            if($card->lastPrice()){
                if($card->rarity=="Common"){
                    $average+=$card->lastPrice()->trend*(10/$this->common);
                }
                if($card->rarity=="Uncommon"){
                    $average+=$card->lastPrice()->trend*(3/$this->uncommon);
                }
                if($card->rarity=="Rare"){
                    $average+=$card->lastPrice()->trend*(7/(8*$this->rare));
                }
                if($card->rarity=="Mythic"){
                    $average+=$card->lastPrice()->trend*(1/(8*$this->mythic));
                }
            }
        }
        return round($average,4);
    }

    public function averageBoosterLow(){
        $average=0;
        foreach ($this->cards as $card) {
            if($card->lastPrice()) {
                if ($card->rarity == "Common") {
                    $average += $card->lastPrice()->low * (10 / $this->common);
                }
                if ($card->rarity == "Uncommon") {
                    $average += $card->lastPrice()->low * (3 / $this->uncommon);
                }
                if ($card->rarity == "Rare") {
                    $average += $card->lastPrice()->low * (7 / (8 * $this->rare));
                }
                if ($card->rarity == "Mythic") {
                    $average += $card->lastPrice()->low * (1 / (8 * $this->mythic));
                }
            }
        }
        return round($average,4);
    }

    public function averageBoosterRare(){
        $average=0;
        foreach($this->cards as $card){
            if($card->lastPrice()){
                if($card->rarity=="Rare"){
                    $average+=$card->lastPrice()->trend*(7/(8*$this->rare));
                }
                if($card->rarity=="Mythic"){
                    $average+=$card->lastPrice()->trend*(1/(8*$this->mythic));
                }
            }
        }
        return round($average,4);
    }

    public function daysFromRelease(){
        return round((time()-strtotime($this->release))/(24*60*60));
    }

    public function daysFromRotation(){
        return round((strtotime($this->rotation)-time())/(24*60*60));
    }

    public function daysFromReleaseDate($date){
        return round((strtotime($date)-strtotime($this->release))/(24*60*60));
    }

    public function daysFromRotationDate($date){
        return round((strtotime($this->rotation)-strtotime($date))/(24*60*60));
    }
}
