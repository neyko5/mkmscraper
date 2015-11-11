<?php

namespace MkmScraper\Console\Commands;

use Illuminate\Console\Command;

class ExportSet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exportset {set}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export set';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filename = $this->argument('set')."set.arff";
        $handle = fopen($filename, 'w+');

        $text="@relation 'price'\n@attribute y {-1,1}\n@attribute x0 numeric\n@attribute x1 numeric\n@attribute x3 numeric\n@attribute x4 numeric\n@attribute x5 numeric\n@attribute x6 numeric\n@attribute x7 numeric\n@attribute x8 numeric\n@attribute x9 numeric\n@data\n\n";
        $set=\MkmScraper\Set::find($this->argument('set'));
        $array=array(array());
        foreach($set->mythics as $card) {
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
        return \Response::download($filename, $this->argument('set').'set.arff', array('Content-Type' => 'text/aarf'));
    }
}



