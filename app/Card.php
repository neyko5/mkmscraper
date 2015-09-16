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
        $this->prices()->where("updated_at","<",date("Y-m-d")." 23:59:59")->where("updated_at",">",date("Y-m-d")." 00:00:00");
    }



}
