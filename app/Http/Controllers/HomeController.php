<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show()
    {
        // Get all the articles from the database
        $articles = Article::all();


        return view('user.articles', compact('articles'));
    }

}
