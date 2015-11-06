<?php

namespace MkmScraper\Http\Controllers;

class EnterController extends Controller
{
    public function showTournaments(){
        return view("tournaments");
    }

    public function processTournament(){
        \MkmScraper\Tournament::create(array("name"=>\Input::get("name"),"date"=>\Input::get("date"),"rank"=>\Input::get("rank"),"limited"=>\Input::get("limited")?1:0));
        return redirect("tournaments")->with(array("message"=>"Tournament was successfully entered."));
    }

    public function showArticles(){
        return view("articles");
    }

    public function processArticle(){
        $article=\MkmScraper\Article::create(array("title"=>\Input::get("title"),"date"=>\Input::get("date"),"popularity"=>\Input::get("popularity"),"publisher"=>\Input::get("publisher"),"link"=>\Input::get("url")));
        $client = new \Goutte\Client();
        $crawler = $client->request('GET',\Input::get("url"));
        if(\Input::get("publisher")=="1"){
            $text=$crawler->filter("#article_content")->text();
        }
        if(\Input::get("publisher")=="2"){
            $text=$crawler->filter(".postContent")->text();
            echo $text;
        }
        if(\Input::get("publisher")=="3"){
            $text=$crawler->filter("#blackborder_main_wrapper .content .field-name-body")->text();
            echo $text;
        }
        if(\Input::get("publisher")=="4"){
            $text=$crawler->filter(".articleBody")->text();
            echo $text;
        }
        $article->text=$text;
        $article->save();
        return redirect("tournaments")->with(array("message"=>"Article <b>".\Input::get("title")." was successfully entered."));
    }
}
