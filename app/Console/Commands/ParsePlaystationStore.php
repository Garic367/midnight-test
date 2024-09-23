<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParsePlaystationStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse-playstation-store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $regions = [
            'en-us' => 'https://store.playstation.com/en-us/pages/browse',
            'en-gb' => 'https://store.playstation.com/en-gb/pages/browse',
            'de-de' => 'https://store.playstation.com/de-de/pages/browse',
            'ja-jp' => 'https://store.playstation.com/ja-jp/pages/browse',
        ];

        foreach ($regions as $regionCode => $url) {
            $this->parseRegion($regionCode, $url);
        }

        $this->info('PlayStation Store data parsed successfully.');
    }

    protected function parseRegion($regionCode, $url)
    {
        for ($page = 1; $page <= 10; $page++) {
            $html = file_get_contents($url . '?page=' . $page);

            $dom = new \DOMDocument();
            @$dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);


            $games = $xpath->query("//a[contains(@class, 'game-link')]");

            $position = 1;

            foreach ($games as $game) {
                $name = trim($game->nodeValue);
                $link = $game->getAttribute('href');


                $genres = $xpath->query(".//div[contains(@class, 'genres')]", $game);
                $releaseDate = $xpath->query(".//div[contains(@class, 'release-date')]", $game);
                $publisher = $xpath->query(".//div[contains(@class, 'publisher')]", $game);
                $reviewsCount = $xpath->query(".//span[contains(@class, 'reviews-count')]", $game);
                $averageRating = $xpath->query(".//span[contains(@class, 'average-rating')]", $game);
                $price = $xpath->query(".//span[contains(@class, 'price')]", $game);


                $genresText = $genres->length ? trim($genres->item(0)->nodeValue) : null;
                $releaseDateText = $releaseDate->length ? trim($releaseDate->item(0)->nodeValue) : null;
                $publisherText = $publisher->length ? trim($publisher->item(0)->nodeValue) : null;
                $reviewsCountValue = $reviewsCount->length ? (int)$reviewsCount->item(0)->nodeValue : null;
                $averageRatingValue = $averageRating->length ? (float)$averageRating->item(0)->nodeValue : null;
                $priceValue = $price->length ? (float)str_replace(['$', '€', '¥'], '', $price->item(0)->nodeValue) : null;


                \App\Models\Game::updateOrCreate(
                    ['link' => $link],
                    [
                        'name' => $name,
                        'link' => $link,
                        'genres' => $genresText,
                        'release_date' => $releaseDateText,
                        'publisher' => $publisherText,
                        'reviews_count' => $reviewsCountValue,
                        'average_rating' => $averageRatingValue,
                        'price' => $priceValue,
                        "{$regionCode}_position" => $position,
                    ]
                );

                $position++;
            }
        }
    }

}
