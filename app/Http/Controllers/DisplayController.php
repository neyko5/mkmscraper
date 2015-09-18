<?php

namespace MkmScraper\Http\Controllers;

class DisplayController extends Controller{

    public function showSets(){
        return view("sets");
    }

    public function showSet($id){
        $data['set']=\MkmScraper\Set::find($id);
        $data['cards']=\MkmScraper\Card::where("id_set",$id)->get();
        return view("set",$data);
    }

    public function showCard($id){
        $data['card']=\MkmScraper\Card::find($id);
        return view("card",$data);
    }

}
