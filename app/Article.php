<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable=array("title","date","text","publisher","popularity","link");

    public function publisher(){
        $array=array("0"=>"None",
                "1"=>"StarCityGames",
                "2"=>"ChannelFireball",
                "3"=>"BlackBorder",
                "4"=>"TCG Player"
        );
        return $array[$this->publisher]; 
    }

    public static function getDiffWeek($date,$card){
        $resultThis=\DB::table("articles")->where("text","LIKE","%".$card->name."%")->where("articles.date","<",$date)->where("articles.date",">=",date('Y-m-d', strtotime($date)-4*24*60*60))->count();
        $resultLast=\DB::table("articles")->where("text","LIKE","%".$card->name."%")->where("articles.date","<",date('Y-m-d', strtotime($date)-4*24*60*60))->where("articles.date",">=",date('Y-m-d', strtotime($date)-7*24*60*60))->count();
        if($resultThis>0){
            return ($resultThis-$resultLast)/$resultLast;
        }
        else {
            return 0;
        }
    }

    public static function getDiffWeekBoolean($date,$card){
        return Article::getDiffWeek($date,$card)>0?"1":"-1";
    }

    public static function getDiffTwoWeek($date,$card){
        $resultThis=\DB::table("articles")->where("text","LIKE","%".$card->name."%")->where("articles.date","<",date('Y-m-d', strtotime($date)-7*24*60*60))->where("articles.date",">=",date('Y-m-d', strtotime($date)-14*24*60*60))->sum(\DB::raw("(5-articles.popularity)"));
        $resultLast=\DB::table("articles")->where("text","LIKE","%".$card->name."%")->where("articles.date","<",date('Y-m-d', strtotime($date)-14*24*60*60))->where("articles.date",">=",date('Y-m-d', strtotime($date)-21*24*60*60))->sum(\DB::raw("(5-articles.popularity)"));
        if($resultThis>0){
            return $resultThis-$resultLast;
        }
        else {
            return 0;
        }
    }

    public static function getDiffThreeWeek($date,$card){
        $resultThis=\DB::table("articles")->where("text","LIKE","%".$card->name."%")->where("articles.date","<",date('Y-m-d', strtotime($date)-14*24*60*60))->where("articles.date",">=",date('Y-m-d', strtotime($date)-21*24*60*60))->sum(\DB::raw("(5-articles.popularity)"));
        $resultLast=\DB::table("articles")->where("text","LIKE","%".$card->name."%")->where("articles.date","<",date('Y-m-d', strtotime($date)-21*24*60*60))->where("articles.date",">=",date('Y-m-d', strtotime($date)-28*24*60*60))->sum(\DB::raw("(5-articles.popularity)"));
        if($resultThis>0){
            return $resultThis-$resultLast;
        }
        else {
            return 0;
        }
    }

    public static function getArticlesWeek($date,$card){
        $resultThis=\DB::table("articles")->where("text","LIKE","%".$card->name."%")->where("articles.date","<",$date)->where("articles.date",">=",date('Y-m-d', strtotime($date)-7*24*60*60))->count();
        return $resultThis;
    }

    public static function getArticlesTwoWeek($date,$card){
        $resultThis=\DB::table("articles")->where("text","LIKE","%".$card->name."%")->where("articles.date","<",date('Y-m-d', strtotime($date)-7*24*60*60))->where("articles.date",">=",date('Y-m-d', strtotime($date)-14*24*60*60))->count();
        return $resultThis;
    }


}
