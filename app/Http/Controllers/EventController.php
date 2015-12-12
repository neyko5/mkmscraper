<?php

namespace MkmScraper\Http\Controllers;

class EventController extends Controller{

    public function index(){
        $data=array();
        return view("events",$data);
    }


}
