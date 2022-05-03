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
            'bolcom' => "Bol.com",
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
            case 'bolcom':
                // $this->scrapeBolComCategories($request->url);
                dd('Not implemented yet');
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
            case 'bolcom':
                // $this->scrapeBolComArticles($request->url);
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

        // Save all the articles in the database if they don't exist yet and add the category id
        foreach ($articles as $article) {
            $art = Article::where('title', $article->title)->first();
            if (!$art) {
                $art = new Article();
                $art->title = $article->title;
                $art->image = $article->image;
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
}
