<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DownloadImageJetPhoto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bizjets:downloadImageJetPhoto {reg?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download an image from jet photo for a plane registration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $reg = $this->argument('reg');

        echo "command called to download :" . $reg . PHP_EOL;

        $url = "https://www.jetphotos.com/registration/" . $reg;

        $client = new Client([
            'timeout'  => 200.0,
            ]);
        $response = $client->request('GET', $url);
        $html = $response->getBody()->getContents();

        $doc = new \DOMDocument();

        $tidy = tidy_parse_string($html);
        $tidy->cleanRepair();

        $html = $tidy->html();

        libxml_use_internal_errors(true);
        $doc->loadHTML(mb_convert_encoding($html, "UTF-8"));
        libxml_clear_errors();

        $xpath = new \DOMXpath($doc);

        // jetphotos
        
        $src = $xpath->evaluate("string(//img[@class='result__photo']/@src)");
        if ($src) {
            $imgSrc =  "https:" . $src;
            $contents=file_get_contents($imgSrc);
            $save_path="/var/www/laravel54/public/planeImages/jetPhotos/".$reg . ".jpg";
            file_put_contents($save_path, $contents);
            
            $alt = $xpath->evaluate("string(//img[@class='result__photo']/@alt)");
            echo "jetphoto " . $alt;
            echo PHP_EOL;
        }
    }
}
