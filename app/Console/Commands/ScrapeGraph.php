<?php

namespace MkmScraper\Console\Commands;

use Illuminate\Console\Command;

class ScrapeGraph extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrapegraph';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape graph prices from MKM with HTML';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new \Goutte\Client();
        foreach(\MkmScraper\Card::all() as $card){
            if(\MkmScraper\GraphPrice::where("id_card",$card->id)->where("date",">",date("Y-m-d",strtotime("-14 days")))->count()<1){
                try{
                    $crawler = $client->request('GET','https://www.magiccardmarket.eu/Products/Singles/'.rawurlencode($card->set).'/'.rawurlencode($card->name));
                    $available=$crawler->filter('#ProductInformation script')->first()->text();
                    $split=explode("chartData =",$available);
                    $split2=explode(";var ctx",$split[1]);
                    $object=json_decode($split2[0]);
                    foreach($object->labels as $key=>$label){
                        if(\MkmScraper\GraphPrice::where("id_card",$card->id)->where("date",date_format(date_create_from_format('d.m.y', $label), 'Y-m-d'))->count()<1){
                            \MkmScraper\GraphPrice::create(array("id_card"=>$card->id,"date"=>date_format(date_create_from_format('d.m.y', $label), 'Y-m-d'),"sell"=>$object->datasets[0]->data[$key]));
                        }
                    }
                    print $card->name."\n";
                }
                catch(Exception $e){
                    print 'https://www.magiccardmarket.eu/Products/Singles/'.rawurlencode($card->set).'/'.rawurlencode($card->name);
                }

            }

        }
    }
}



