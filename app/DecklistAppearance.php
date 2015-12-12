<?php

namespace MkmScraper;

use Illuminate\Database\Eloquent\Model;

class DecklistAppearance extends Model
{
    protected $fillable=array("id_card","place","rank","number","id_event");

    public function event(){
        return $this->belongsTo("\MkmScraper\Event","id_event");
    }

    public static function tournamentDiffLastWeek1($date,$card){
        $allnow=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime($date)))->where("events.date",">=",date('Y-m-d', strtotime($date)-7*24*60*60))->sum(\DB::raw("(5-events.rank)*(5-events.rank)*(9-decklist_appearances.place)"));
        $cardnow=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$card->id)->where("events.date","<",date('Y-m-d', strtotime($date)))->where("events.date",">=",date('Y-m-d', strtotime($date)-7*24*60*60))->sum(\DB::raw("(5-events.rank)*(5-events.rank)*(9-decklist_appearances.place)"));
        $allthen=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime($date)-7*24*60*60))->where("events.date",">=",date('Y-m-d', strtotime($date)-14*24*60*60))->sum(\DB::raw("(5-events.rank)*(5-events.rank)*(9-decklist_appearances.place)"));
        $cardthen=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$card->id)->where("events.date","<",date('Y-m-d', strtotime($date)-7*24*60*60))->where("events.date",">=",date('Y-m-d', strtotime($date)-14*24*60*60))->sum(\DB::raw("(5-events.rank)*(5-events.rank)*(9-decklist_appearances.place)"));

        if($allnow>0 && $allthen>0){
            return round(100*$cardnow/$allnow,3)-round(100*$cardthen/$allthen,3);
        }
        else{
            return 0;
        }
    }

    public static function tournamentDiffLastWeek($date,$card){
        $allnow=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime($date)))->where("events.date",">=",date('Y-m-d', strtotime($date)-7*24*60*60))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)*number"));
        $cardnow=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$card->id)->where("events.date","<",date('Y-m-d', strtotime($date)))->where("events.date",">=",date('Y-m-d', strtotime($date)-7*24*60*60))->sum(\DB::raw("(5-events.rank)*(5-events.rank)*(9-decklist_appearances.place)*number"));
        $allthen=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime($date)-7*24*60*60))->where("events.date",">=",date('Y-m-d', strtotime($date)-14*24*60*60))->sum(\DB::raw("(5-events.rank)*(5-events.rank)*(9-decklist_appearances.place)*number"));
        $cardthen=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$card->id)->where("events.date","<",date('Y-m-d', strtotime($date)-7*24*60*60))->where("events.date",">=",date('Y-m-d', strtotime($date)-14*24*60*60))->sum(\DB::raw("(5-events.rank)*(5-events.rank)*(9-decklist_appearances.place)*number"));

        if($allnow>0 && $allthen>0){
            return round(100*$cardnow/$allnow,3)-round(100*$cardthen/$allthen,3);
        }
        else{
            return 0;
        }
    }

    public static function tournamentDiffLastWeekBoolean($date,$card){
        return DecklistAppearance::tournamentDiffLastWeek($date,$card)>=0?"1":"-1";
    }

    public static function tournamentLastWeek($date,$card){
        $allnow=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("events.date","<",date('Y-m-d', strtotime($date)))->where("events.date",">=",date('Y-m-d', strtotime($date)-7*24*60*60))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)*number"));
        $cardnow=\DB::table("decklist_appearances")->join('events', 'events.id', '=', 'decklist_appearances.id_event')->where("id_card",$card->id)->where("events.date","<",date('Y-m-d', strtotime($date)))->where("events.date",">=",date('Y-m-d', strtotime($date)-7*24*60*60))->sum(\DB::raw("(5-events.rank)*(9-decklist_appearances.place)*number"));
        if($allnow>0){
            return round(100*$cardnow/$allnow,3);
        }
        else{
            return 0;
        }
    }


}
