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
                $row[] = 1/pow(pow(2.71828,$price->card->set->daysFromReleaseDate($price->date)),0.2);
                $row[] = 1/pow(pow(2.71828,$price->card->set->daysFromRotationDate($price->date)),0.2);
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
        return \Response::download($filename, 'set.arff', array('Content-Type' => 'text/aarf'));
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
                $row[] = 1/pow(pow(2.71828,$price->card->set->daysFromReleaseDate($price->date)),0.2);
                $row[] = 1/pow(pow(2.71828,$price->card->set->daysFromRotationDate($price->date)),0.2);
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
}
