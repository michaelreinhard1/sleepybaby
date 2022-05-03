<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function show()
    {
        // Get all the articles from the database
        $articles = Article::all();

        return view('scraper-articles', compact('articles'));
    }
}
