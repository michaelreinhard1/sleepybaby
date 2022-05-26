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
            'hema' => "hema",
            'babyplanet' => "babyplanet",
            'kidsdeco' => "kidsdeco",
        ];

        // Get al the categories from the database
        $categories = Category::all();

        return view('admin.scraper', [
            'categories' => $categories,
            'shops' => $shops
        ]);
    }

    public function scrapeCategories(Request $request)
    {
        switch ($request->shop) {
            case 'hema':
                return $this->scrapeHemaCategories($request->url);
                break;
            case 'babyplanet':
                return $this->scrapeBabyPlanetCategories($request->url);
                break;
            case 'kidsdeco':
                return $this->scrapeKidsDecoCategories($request->url);
                break;
        }
    }

    private function scrapeHemaCategories($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $categories = $crawler->filter('body > div.container > div.content.lister-page.js-load-search.clearfix > div.sidebar.sticky-parent > div > ul > li > ul > li')->each(function ($node) {
            $cat = new stdClass();
            $cat->title = $node->filter('a')->text();
            $cat->url = $node->filter('a')->attr('href');

            return $cat;
        });

        // If categories is empty, then the url is not correct
        if (empty($categories)) {
            return redirect()->route('admin.scraper')->with('error', __('The url is not correct, please try again'));
        }


        // Save all the categories in the database if they don't exist yet
        foreach ($categories as $category) {
            $cat = Category::where('title', $category->title)->first();
            if (!$cat) {
                $cat = new Category();
                $cat->title = $category->title;
                $cat->url = $category->url;
                $cat->shop = 'hema';
                $cat->save();
            }
        }


        return redirect()->route('admin.scraper')->with('success', __('The categories were successfully scraped'));

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
            return redirect()->route('admin.scraper')->with('error', __('The url is not correct, please try again'));
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

        return redirect()->route('admin.scraper')->with('success', __('The categories were successfully scraped'));
    }

    private function scrapeKidsDecoCategories($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);


        $categories = $crawler->filter('#narrow-by-list > div.layered-navigation__filter.filter-options-item.layered-navigation__filter--opened.active > div.layered-navigation__content.filter-options-content > ol > li.item.layered-navigation__item.layered-navigation__item--parent.layered-navigation__item--active > ol > li')->each(function ($node) {
            $cat = new stdClass();
            $cat->title = $node->filter('a')->text();
            $cat->url = $node->filter('a')->attr('href');

            return $cat;
        });

        // If categories is empty, then the url is not correct
        if (empty($categories)) {
            return redirect()->route('admin.scraper')->with('error', __('The url is not correct, please try again'));
        }


        // Save all the categories in the database if they don't exist yet
        foreach ($categories as $category) {
            $cat = Category::where('title', $category->title)->first();
            if (!$cat) {
                $cat = new Category();
                $cat->title = $category->title;
                $cat->url = $category->url;
                $cat->shop = 'kidsdeco';
                $cat->save();
            }
        }

        return redirect()->route('admin.scraper')->with('success', __('The categories were successfully scraped'));
    }

    public function scrapeArticles(Request $request)
    {

        switch ($request->shop) {
            case 'hema':
                return $this->scrapeHemaArticles($request);
                break;
            case 'babyplanet':
                return $this->scrapeBabyPlanetArticles($request);
                break;
            case 'kidsdeco':
                return $this->scrapeKidsDecoArticles($request);
                break;
            }
    }



    private function scrapeHemaArticles($request)
    {

        $client = new Client();
        $crawler = $client->request('GET', $request->url);

        $articles=array();

        $crawler->filter('div.container > div.content.lister-page.js-load-search.clearfix > div.main-content > div.search-result-content > div > div')->each(function ($node) use (&$articles) {
            // Fore each product inside product-row-wrap
            // Make an empty array to store the data
            $node->filter('.product-container')->each(function ($node) use (&$articles) {

                $art = new stdClass();
                $art->title = $node->filter('.product .product-info h3 a')->text();
                $art->url = $node->filter('.product .product-info h3 a')->attr('href');
                $art->price = $node->filter('.product .product-price .price')->text();
                $art->price = $this->formatPrice($art->price);
                $art->image = $node->filter('.product .product-image a img')->attr('data-thumb');
                // Get src inside json data-thumb
                $art->image = json_decode($art->image)->src;

                // Check if price.old is inside price
                if ($node->filter('.product .product-price .price-old')->count() > 0) {
                    $art->price_old = $node->filter('.product .product-price .price-old')->text();
                } else {
                    $art->price_old = null;
                }

                // Push the data to the array
                array_push($articles,$art);

            });


        });

        if (empty($articles)) {
            return redirect()->route('admin.scraper')->with('error', __('The url is not correct, please try again'));
        }

        // Save all the articles in the database if they don't exist yet and add the category id
        foreach ($articles as $article) {
            $art = Article::where('title', $article->title)->first();
            if (!$art) {
                $art = new Article();
                $art->title = $article->title;
                $art->image = $this->saveImage($article->image);
                $art->url = 'https://www.hema.com/' . $article->url;
                $art->price = $article->price;
                $art->price = $this->formatPrice($art->price);
                $art->shop = 'hema';

                $cat = Category::where('id', $request->id)->first();
                $art->category_id = $cat->id;
                $art->category = $cat->title;
                $art->save();
            }
            else {
                unset($articles[array_search($article, $articles)]);
            }
        }

        $count = count($articles);

        if (empty($articles)) {
            return redirect()->route('admin.scraped.articles')->with('warning', __('The articles were already scraped') . $count . __('articles were added to the databsase'));
        }

        return redirect()->route('admin.scraped.articles')->with('success', __('The articles were successfully scraped'). $count . __('articles added to the databsase'));
    }

    private function scrapeBabyPlanetArticles($request)
    {


        $client = new Client();
        $crawler = $client->request('GET', $request->url);

        $articles = $this->scrapeBabyPlanetPageData($crawler);

        for ($i = 0; $i <= 50; $i++) {
            set_time_limit(0);
            $crawler = $this->getNextBabyPlanetPage($crawler);
            if (!$crawler) break;
            $articles = array_merge($articles, $this->scrapeBabyPlanetPageData($crawler));
        }

        if (empty($articles)) {
            return redirect()->route('admin.scraper')->with('error', __('The url is not correct, please try again'));
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
                $art->price = $this->formatPrice($art->price);

                $art->shop = 'babyplanet';

                $cat = Category::where('id', $request->id)->first();
                $art->category_id = $cat->id;
                $art->category = $cat->title;
                $art->save();
            }
            else {
                unset($articles[array_search($article, $articles)]);
            }
        }


        // Count the articles
        $count = count($articles);

        if (empty($articles)) {
            return redirect()->route('admin.scraped.articles')->with('warning', __('The articles were already scraped.' ). $count . __('articles were added to the databsase'));
        }

        return redirect()->route('admin.scraped.articles')->with('success', __('The articles were successfully scraped.') . $count . __('articles added to the databsase'));

    }

    private function scrapeBabyPlanetPageData($crawler) {
        return $crawler->filter('#amasty-shopby-product-list > div.products.wrapper.grid.products-grid > ol > li')->each(function ($node) {

            $art = new stdClass();
            $art->title = $node->filter('div > div > strong > a')->text();
            $art->price = $node->filter('div > .product-item-details > .product-item-inner > .price-box span.price')->text();
            $art->price = $this->formatPrice($art->price);

            $art->image = $node->filter('div > a > span > span > img')->attr('src');
            $art->url = $node->filter('div > a')->attr('href');

            return $art;
        });
    }

    private function getNextBabyPlanetPage($crawler) {
        $element = $crawler->filter('#amasty-shopby-product-list > div.toolbar.toolbar-products > div.pages > ul > li.item.pages-item-next > a');
        if ($element->count() == 0) return false;
        $link = $element->selectLink('Volgende stap')->link();

        $client = new Client();
        $crawler = $client->click($link);

        return $crawler;
    }

    private function scrapeKidsDecoArticles($request)
    {


        $client = new Client();
        $crawler = $client->request('GET', $request->url);

        $articles = $this->scrapeKidsDecoPageData($crawler);

        for ($i = 0; $i <= 50; $i++) {
            set_time_limit(0);
            $crawler = $this->getNextKidsDecoPage($crawler);
            if (!$crawler) break;
            $articles = array_merge($articles, $this->scrapeKidsDecoPageData($crawler));
        }


        if (empty($articles)) {
            return redirect()->route('admin.scraper')->with('error', __('The url is not correct, please try again'));
        }


        foreach ($articles as $article) {
            $art = Article::where('title', $article->title)->first();
            if (!$art) {
                $art = new Article();
                $art->title = $article->title;
                $art->image = $this->saveImage($article->image);
                $art->url = $article->url;
                $art->price = $article->price;
                $art->price = $this->formatPrice($art->price);

                $art->shop = 'kidsdeco';

                $cat = Category::where('id', $request->id)->first();
                $art->category_id = $cat->id;
                $art->category = $cat->title;
                $art->save();
            }

        }

        $count = count($articles);

        if (empty($articles)) {
            return redirect()->route('admin.scraped.articles')->with('warning', __('The articles were already scraped') . $count . __('articles were added to the databsase'));
        }

        return redirect()->route('admin.scraped.articles')->with('success', __('The articles were successfully scraped' ). $count . __('articles added to the databsase'));
    }

    private function scrapeKidsDecoPageData($crawler) {
        return $crawler->filter('.products.products-grid > ol > li.item.product.product-item.product-item-container')->each(function ($node) {

            $art = new stdClass();
            $art->title = $node->filter('.product.name.product-item-name a.product-item-link')->text();
            $art->price = $node->filter('span[data-price-amount]')->attr('data-price-amount');
            $art->price = $this->formatPrice($art->price);

            $art->image = $node->filter('picture > source')->attr('srcset');
            $art->url = $node->filter('a.product-item-link')->attr('href');

            return $art;
        });
    }

    private function getNextKidsDecoPage($crawler) {
        $element = $crawler->filter('ul.pages-items > li.pages-item-next > a');
        if ($element->count() == 0) return false;
        $link = $element->link();

        $client = new Client();
        $crawler = $client->click($link);

        return $crawler;
    }

    private function saveImage($image_url) {
        // Download the image url in the public images folder and give the image a unique name
        $image_name = uniqid() . '.jpg';
        $image_path = public_path('images/' . $image_name);

        // Save the image in the public images folder
        $image = file_get_contents($image_url);
        file_put_contents($image_path, $image);

        return $image_name;
    }

    private function formatPrice($price) {
        $price = str_replace('€', '', $price);
        $price = str_replace('.', '.', $price);
        $price = str_replace(',', '.', $price);
        return $price;
    }

    // Show all the articles
    public function showArticles() {
        // Get all the articles from the database
        $articles = Article::paginate(10);

        // Get all the categories from the articles
        $categories = $articles->pluck('category')->unique();

        // Only pass the category the user has selected
        $selectedCategory = request()->category;

        return view('admin.articles', compact('articles', 'categories'));
    }
}
