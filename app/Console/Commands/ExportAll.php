<?php

namespace MkmScraper\Console\Commands;

use Illuminate\Console\Command;

class ExportAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exportall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all sets';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filename = "all.arff";
        $handle = fopen($filename, 'w+');

        $text="@relation 'price'\n@attribute y {-1,1}\n@attribute x0 numeric\n@attribute x1 numeric\n@attribute x3 numeric\n@attribute x4 numeric\n@attribute x5 numeric\n@attribute x6 numeric\n@attribute x7 numeric\n@attribute x8 numeric\n@attribute x9 numeric\n@attribute x10 numeric\n@attribute x11 numeric\n@data\n\n";
        $array=array(array());
        foreach(\MkmScraper\Card::where("rarity","Mythic")->get() as $card) {
            foreach ($card->graphPrices as $key => $price) {
                $row = array();
                $row[] = $price->priceClass();
                $row[] = 1/pow(pow(2.71828,$price->card->set->daysFromReleaseDate($price->date)),0.2);
                $row[] = 1/pow(pow($price->card->set->daysFromRotationDate($price->date)),0.2);
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
    }
}



