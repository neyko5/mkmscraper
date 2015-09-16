<?php

namespace MkmScraper\Http\Controllers;

class ScrapeController extends Controller
{
    public function processWizards(){
        $client = new \Goutte\Client();
        $crawler = $client->request('GET',\Input::get("url_1"));
        $event=\MkmScraper\Event::create(array("name"=>\Input::get("name"),"date"=>\Input::get("date"),"rank"=>\Input::get("rank")));
        if (($handle = fopen(\Input::get("url_1"), "r")) !== FALSE) {
            while ($data = fgets($handle) !== FALSE) {
                print $data;
            }
        }
    }
}
