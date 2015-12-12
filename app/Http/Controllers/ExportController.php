<?php

namespace MkmScraper\Http\Controllers;

class ExportController extends Controller
{
    public function exportCard($id){
        $filename = "export.arff";
        $handle = fopen($filename, 'w+');

        $text="@relation 'price'\n@attribute y {-1,1}\n@attribute x0 numeric\n@attribute x1 numeric\n@attribute x3 numeric\n@attribute x4 numeric\n@attribute x5 numeric\n@attribute x6 numeric\n@attribute x7 numeric\n@attribute x8 numeric\n@attribute x9 numeric\n@data\n\n";

        $array=array(array());
        $card=\MkmScraper\Card::find($id);
        foreach ($card->graphPrices as $key => $price) {
            $row = array();
            $row[] = $price->priceClass();
            $row[] = $price->card->set->daysFromReleaseDate($price->date);
            $row[] = $price->card->set->daysFromRotationDate($price->date);
            $row[] = $price->tournamentDiffWeek();
            $row[] = $price->tournamentDiffTwoWeek();
            $row[] = $price->articlesDiffLastWeek();
            $row[] = $price->articlesDiffLastTwoWeek();
            $row[] = $price->otherCardMovementDay();
            $row[] = $price->otherCardMovementWeek();
            $row[] = $price->boostersOpen();
            $array[] = $row;
        }
        foreach($array as $row){
            foreach($row as $item){
                $text.=$item.",";
            }
            $text.="\n";
        }
        file_put_contents ($filename , $text);
        return \Response::download($filename, 'export.arff', array('Content-Type' => 'text/aarf'));
    }

    public function exportCardNew($id){
        $filename = "export.arff";
        $handle = fopen($filename, 'w+');

        $text="@relation 'price'\n@attribute y {-1,1}\n@attribute x0 numeric\n@attribute x1 numeric\n@attribute x2 numeric\n@attribute x3 numeric\n@data\n\n";

        $array=array(array());
        $card=\MkmScraper\Card::find($id);
        $date="2015-09-03";
        while($date<"2015-12-10"){
            $row = array();

            $row[]=\MkmScraper\GraphPrice::getPriceSingleWeekBoolean($date,$card);
            $row[]=\MkmScraper\DecklistAppearance::tournamentDiffLastWeek(date("Y-m-d",strtotime($date)-14*24*60*60),$card);
            $row[]=\MkmScraper\Article::getDiffWeek(date("Y-m-d",strtotime($date)-7*24*60*60),$card);
            $row[]=\MkmScraper\GraphPrice::getPriceOtherSingleWeek(date("Y-m-d",strtotime($date)-7*24*60*60),$card);
            $row[]=$card->distanceFromRotationExp($date);
            //$row[]=$card->daysFromRelease($date);

            $array[] = $row;

            $date=date("Y-m-d",strtotime($date)+7*24*60*60);
        }
        foreach($array as $row){
            foreach($row as $item){
                $text.=$item.",";
            }
            $text.="\n";
        }
        file_put_contents ($filename , $text);
        return \Response::download($filename, 'export.arff', array('Content-Type' => 'text/aarf'));
    }

    public function exportSet($id){
        $filename = "set.arff";
        $handle = fopen($filename, 'w+');

        $text="@relation 'price'\n@attribute y {-1,1}\n@attribute x0 numeric\n@attribute x1 numeric\n@attribute x3 numeric\n@attribute x4 numeric\n@attribute x5 numeric\n@attribute x6 numeric\n@attribute x7 numeric\n@attribute x8 numeric\n@attribute x9 numeric\n@data\n\n";
        $set=\MkmScraper\Set::find($id);
        $array=array(array());
        foreach($set->mythics as $card) {
            foreach ($card->graphPrices as $key => $price) {
                $row = array();
                $row[] = $price->priceClass();
                $row[] = $price->tournamentDiffWeek();
                $row[] = $price->articlesDiffLastWeek();
                $array[] = $row;
            }
        }
        foreach($array as $row){
            foreach($row as $item){
                $text.=$item.",";
            }
            $text.="\n";
        }
        file_put_contents ($filename , $text);
        return \Response::download($filename, 'set.arff', array('Content-Type' => 'text/aarf'));
    }

    public function exportSetNew($id){
        $filename = "export.arff";
        $handle = fopen($filename, 'w+');

        $text="@relation 'price'\n@attribute y {-1,1}\n@attribute x0 numeric\n@attribute x1 numeric\n@data\n\n";

        $array=array(array());
        $set=\MkmScraper\Set::find($id);
        foreach($set->mythics as $card) {
            $date="2015-09-03";
            while($date<"2015-12-10"){
                $row = array();
                //$objects['sell'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\GraphPrice::getPriceWeek($date,$this));
                //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getArticlesWeek($date,$this));
                $articles=\MkmScraper\Article::getDiffWeek(date("Y-m-d",strtotime($date)+21*24*60*60),$card);
                if($articles>0){
                    $row[]=\MkmScraper\GraphPrice::getPriceDiffWeekBoolean($date,$card);
                    $row[]=\MkmScraper\DecklistAppearance::tournamentDiffLastWeek($date,$card);
                    $row[]=\MkmScraper\Article::getDiffWeek(date("Y-m-d",strtotime($date)+21*24*60*60),$card);

                    $row[]=$articles;
                    $array[] = $row;
                }
                //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getDiffWeek($date,$this));
                $date=date("Y-m-d",strtotime($date)+7*24*60*60);

            }
        }
        foreach($array as $row){
            foreach($row as $item){
                $text.=$item.",";
            }
            $text.="\n";
        }
        file_put_contents ($filename , $text);
        return \Response::download($filename, 'export.arff', array('Content-Type' => 'text/aarf'));
    }

    public function exportSetNewCsv($id){
        $filename = "export.csv";
        $handle = fopen($filename, 'w+');

        $text="x,y,Class\n";

        $array=array(array());
        $set=\MkmScraper\Set::find($id);
        foreach($set->mythics as $card) {
            $date="2015-09-03";
            while($date<"2015-12-10"){
                $row = array();
                //$objects['sell'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\GraphPrice::getPriceWeek($date,$this));
                //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getArticlesWeek($date,$this));
                $articles=\MkmScraper\Article::getDiffTwoWeek($date,$card);
                if($articles>0){
                    $row[]=\MkmScraper\DecklistAppearance::tournamentDiffLastWeek($date,$card);
                    $row[]=$articles;
                    $row[]=\MkmScraper\GraphPrice::getPriceDiffWeekBoolean($date,$card);
                    $array[] = $row;
                }
                //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getDiffWeek($date,$this));
                $date=date("Y-m-d",strtotime($date)+7*24*60*60);

            }
        }
        foreach($array as $row){
            foreach($row as $item){
                $text.=$item.",";
            }
            $text=rtrim($text, ",");
            $text.="\n";
        }

        file_put_contents ($filename , $text);
        return \Response::download($filename, 'export.csv', array('Content-Type' => 'text/csv'));
    }

    public function exportAll(){
        $filename = "all.arff";
        $handle = fopen($filename, 'w+');

        $text="@relation 'price'\n@attribute y {-1,1}\n@attribute x0 numeric\n@attribute x1 numeric\n@attribute x3 numeric\n@attribute x4 numeric\n@attribute x5 numeric\n@attribute x6 numeric\n@attribute x7 numeric\n@attribute x8 numeric\n@attribute x9 numeric\n@attribute x10 numeric\n@attribute x11 numeric\n@data\n\n";
        $array=array(array());
        foreach(\MkmScraper\Card::where("rarity","Mythic")->get() as $card) {
            foreach ($card->graphPrices as $key => $price) {
                $row = array();
                $row[] = $price->priceClass();
                $row[] = $price->card->set->daysFromReleaseDate($price->date);
                $row[] = $price->card->set->daysFromRotationDate($price->date);
                $row[] = $price->tournamentDiffWeek();
                $row[] = $price->tournamentDiffTwoWeek();
                $row[] = $price->articlesDiffLastWeek();
                $row[] = $price->articlesDiffLastTwoWeek();
                $row[] = $price->otherCardMovementDay();
                $row[] = $price->otherCardMovementWeek();
                $row[] = $price->boostersOpen();
                $array[] = $row;
            }
        }
        foreach($array as $row){
            foreach($row as $item){
                $text.=$item.",";
            }
            $text.="\n";
        }
        file_put_contents ($filename , $text);
        return \Response::download($filename, 'all.arff', array('Content-Type' => 'text/aarf'));
    }

    public function exportAllNew(){
        $filename = "export.arff";
        $handle = fopen($filename, 'w+');

        $text="@relation 'price'\n@attribute y {-1,1}\n@attribute x0 numeric\n@data\n\n";

        $array=array(array());
        foreach(\MkmScraper\Card::where("rarity","Mythic")->get() as $card) {
            $date="2015-09-03";
            while($date<"2015-12-10"){
                $row = array();
                //$objects['sell'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\GraphPrice::getPriceWeek($date,$this));
                //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getArticlesWeek($date,$this));
                $articles=\MkmScraper\Article::getDiffWeek(date("Y-m-d",strtotime($date)+21*24*60*60),$card);
                if($articles>0){
                    $row[]=\MkmScraper\DecklistAppearance::tournamentDiffLastWeek($date,$card);
                    $row[]=\MkmScraper\GraphPrice::getPriceDiffWeekBoolean($date,$card);
                    $row[]=$articles;
                    $array[] = $row;
                }
                //$objects['art'][]=array($dateexp[0], $dateexp[1],$dateexp[2],\MkmScraper\Article::getDiffWeek($date,$this));
                $date=date("Y-m-d",strtotime($date)+7*24*60*60);

            }
        }
        foreach($array as $row){
            foreach($row as $item){
                $text.=$item.",";
            }
            $text.="\n";
        }
        file_put_contents ($filename , $text);
        return \Response::download($filename, 'export.arff', array('Content-Type' => 'text/aarf'));
    }
}
