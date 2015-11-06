<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable=array("title","date","text","publisher","popularity");

    public function publisher(){
        $array=array("0"=>"None",
                "1"=>"StarCityGames",
                "2"=>"ChannelFireball",
                "3"=>"BlackBorder",
                "4"=>"TCG Player"
        );
        return $array[$this->publisher]; 
    }
}
