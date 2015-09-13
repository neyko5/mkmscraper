<?php

namespace MkmScraper\Console\Commands;

use Illuminate\Console\Command;

class ScrapeHtml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrapehtml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape prices from MKM via HTML';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new \Goutte\Client();
        foreach(\MkmScraper\Card::all() as $card){
            $crawler = $client->request('GET','https://www.magiccardmarket.eu/Products/Singles/'.rawurlencode($card->set).'/'.rawurlencode($card->name));
            $available=$crawler->filter('.sectioncontent .availTable .row_0  .cell_0_1')->first()->text();
            $low=$crawler->filter('.sectioncontent .availTable .row_1  .cell_1_1 span')->first()->text();
            $lowfinal=str_replace(",",".",$low);
            $trend=$crawler->filter('.sectioncontent .availTable .row_2  .cell_2_1')->first()->text();
            $trendnumber=explode(" ",$trend);
            $trendfinal=str_replace(",",".",$trendnumber[0]);
            $cardPrice=\MkmScraper\CardPrice::create(array("id_card"=>$card->id,"low"=>$lowfinal,"trend"=>$trendfinal,"sellers"=>$available));
        }
    }
}
