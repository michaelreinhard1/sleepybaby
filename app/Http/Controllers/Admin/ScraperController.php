<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Goutte\Client;
use stdClass;
use App\Models\Category;
use App\Models\Article;

class ScraperController extends Controller
{
    public function show()
    {

        $shops = [
            'petiteamelie' => "Petite Amelie",
            'babyplanet' => "babyplanet",
        ];

        // Get al the categories from the database
        $categories = Category::all();

        return view('scraper', [
            'categories' => $categories,
            'shops' => $shops
        ]);
    }

    public function scrapeCategories(Request $request)
    {
        switch ($request->shop) {
            case 'petiteamelie':
                return $this->scrapePetiteAmelieCategories($request->url);
                break;
            case 'babyplanet':
                return $this->scrapeBabyPlanetCategories($request->url);
                break;
        }
    }

    private function scrapePetiteAmelieCategories($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('#nav > .nav-4 .sub-wrap > ul > li')->each(function ($node) {
            $cat = new stdClass();
            $cat->title = $node->filter('a > figure > figcaption')->text();
            $cat->url = $node->filter('a')->attr('href');
            
            return $cat;
        });
        
        // If categories is empty, then the url is not correct
        if (empty($categories)) {
            return redirect()->route('scraper')->with('error', 'The url is not correct, please try again');
        }


        // Save all the categories in the database if they don't exist yet
        foreach ($categories as $category) {
            $cat = Category::where('title', $category->title)->first();
            if (!$cat) {
                $cat = new Category();
                $cat->title = $category->title;
                $cat->url = $category->url;
                $cat->shop = 'petiteamelie';
                $cat->save();
            }
        }


        return redirect()->route('scraper')->with('success', 'The categories were successfully scraped');

    }
    private function scrapeBabyPlanetCategories($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        

        $categories = $crawler->filter('.categories > div.body > ul.list > li')->each(function ($node) {
            $cat = new stdClass();
            $cat->title = $node->filter('a')->text();
            $cat->url = $node->filter('a')->attr('href');
            
            return $cat;
        });
        
        // If categories is empty, then the url is not correct
        if (empty($categories)) {
            return redirect()->route('scraper')->with('error', 'The url is not correct, please try again');
        }


        // Save all the categories in the database if they don't exist yet
        foreach ($categories as $category) {
            $cat = Category::where('title', $category->title)->first();
            if (!$cat) {
                $cat = new Category();
                $cat->title = $category->title;
                $cat->url = $category->url;
                $cat->shop = 'babyplanet';
                $cat->save();
            }
        }


        return redirect()->route('scraper')->with('success', 'The categories were successfully scraped');

    }

    public function scrapeArticles(Request $request)
    {

        switch ($request->shop) {
            case 'petiteamelie':
                return $this->scrapePetiteAmelieArticles($request);
                break;
            case 'babyplanet':
                return $this->scrapeBabyPlanetArticles($request);
                dd('Not implemented yet');
                break;
            }
    }



    private function scrapePetiteAmelieArticles($request)
    {


        $client = new Client();
        $crawler = $client->request('GET', $request->url);

        $articles = $crawler->filter('#products-list > li')->each(function ($node) {
            $art = new stdClass();
            $art->title = $node->filter('.product-shop h2')->text();
            $art->price = $node->filter('.product-shop .price-box .price')->text();
            $art->image = $node->filter('figure > img')->attr('src');
            $art->url = $node->filter('a')->attr('href');

            return $art;
        });

        if (empty($articles)) {
            return redirect()->route('scraper')->with('error', 'The url is not correct, please try again');
        }

        // Save all the articles in the database if they don't exist yet and add the category id
        foreach ($articles as $article) {
            $art = Article::where('title', $article->title)->first();
            if (!$art) {
                $art = new Article();
                $art->title = $article->title;
                $art->image = $this->saveImage($article->image);
                $art->url = $article->url;
                $art->price = $article->price;
                
                $cat = Category::where('id', $request->id)->first();
                $art->category_id = $cat->id;
                $art->category = $cat->title;
                $art->save();
            }
            
        }

        return redirect()->route('articles')->with('success', 'The categories were successfully scraped');
    }
    private function scrapeBabyPlanetArticles($request)
    {


        $client = new Client();
        $crawler = $client->request('GET', $request->url);

        $articles = $this->scrapeBabyPlanetPageData($crawler);

        // Loop until $this->getNextBabyPlanetPage($crawler) returns false
        // while ($this->getNextBabyPlanetPage($crawler)) {
        //     set_time_limit(0);
        //     $crawler = $this->getNextBabyPlanetPage($crawler);
        //     if (!$crawler) break;
        //     $articles = array_merge($articles, $this->scrapeBabyPlanetPageData($crawler));
        // }

        for ($i = 0; $i <= 50; $i++) {
            set_time_limit(0);
            $crawler = $this->getNextBabyPlanetPage($crawler);
            if (!$crawler) break;
            $articles = array_merge($articles, $this->scrapeBabyPlanetPageData($crawler));
        }

        if (empty($articles)) {
            return redirect()->route('scraper')->with('error', 'The url is not correct, please try again');
        }

        // Save all the articles in the database if they don't exist yet and add the category id
        foreach ($articles as $article) {
            $art = Article::where('title', $article->title)->first();
            if (!$art) {
                $art = new Article();
                $art->title = $article->title;
                $art->image = $this->saveImage($article->image);
                $art->url = $article->url;
                $art->price = $article->price;
                $cat = Category::where('id', $request->id)->first();
                $art->category_id = $cat->id;
                $art->category = $cat->title;
                $art->save();
            }
            
        }

        return redirect()->route('articles')->with('success', 'The categories were successfully scraped');
    }

    private function scrapeBabyPlanetPageData($crawler) {
        return $crawler->filter('#amasty-shopby-product-list > div.products.wrapper.grid.products-grid > ol > li')->each(function ($node) {

            $art = new stdClass();
            $art->title = $node->filter('div > div > strong > a')->text();
            $art->price = $node->filter('div > .product-item-details > .product-item-inner > .price-box span.price')->text();
            $art->image = $node->filter('div > a > span > span > img')->attr('src');
            $art->url = $node->filter('div > a')->attr('href');

            return $art;
        });
    }

    private function getNextBabyPlanetPage($crawler) {
        $link = $crawler->filter('#amasty-shopby-product-list > div.toolbar.toolbar-products > div.pages > ul > li.item.pages-item-next > a')->selectLink('Volgende stap')->link();
        if (!$link) return false;

        $client = new Client();
        $crawler = $client->click($link);

        return $crawler;
    }

    private function saveImage($image) {
        // Download the image and save it locally with the a random name
        $image_name = md5(rand());
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $image_path = public_path('images/' . $image_name . '.' . $image_extension);
        $image_url = $image;

        // Save the image locally with the random name
        $image_data = file_get_contents($image_url);
        file_put_contents($image_path, $image_data);

        return ($image_name . '.' . $image_extension);
    }
}
