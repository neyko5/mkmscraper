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


}
