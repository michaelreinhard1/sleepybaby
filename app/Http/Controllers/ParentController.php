<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParentController extends Controller
{
    public function show()
    {
        // Get all articles from the database and pass them to the view
        $articles = Article::paginate(24);

        return view('parent.home', ['articles' => $articles]);
    }
    // showWishlist
    public function showWishlists()
    {

        // show wishlist of the user
        $wishlists = Wishlist::where('user_id', auth()->user()->id)->get();

        return view('parent.wishlist', compact('wishlists'));
    }

    // create wishlist
    public function createWishlist()
    {
        // Get all wishlists from the database and pass them to the view
        $wishlists = Wishlist::paginate(24);

        return view('parent.wishlist-create', compact('wishlists'));
    }
    // storeWishlist
    public function storeWishlist(Request $request)
    {
        // Store the new wishlist in the database
        $wishlist = new Wishlist();
        $wishlist->user_id = auth()->user()->id;
        $wishlist->name = $request->input('name');
        $wishlist->description = $request->input('description');
        $wishlist->article_id = json_encode([]);

        // generate a unique number for the code
        $wishlist->code = random_int(10000, 99999);

        $wishlist->save();

        return redirect()->route('parent.wishlists.show')->with('success', 'Wishlist created successfully.');
    }

    public function destroyWishlist($id)
    {
        // Find the wishlist with the id
        $wishlist = Wishlist::find($id);

        // Delete the wishlist
        $wishlist->delete();

        return redirect()->route('parent.wishlists.show')->with('success', 'Wishlist deleted successfully.');
    }

    public function showWishlist($id)
    {

        // Find the wishlist with the id
        $wishlist = Wishlist::find($id);

        // Get all articles with id in wishlist->article_id
        $articles = Article::whereIn('id', json_decode($wishlist->article_id))->get();

        return view('parent.wishlist-detail', compact('wishlist', 'articles'));
    }

    // showArticles
    public function showArticles($wishlist_id)
    {
        // get wishlist
        $wishlist = Wishlist::find($wishlist_id);
        // Get all articles from the database and pass them to the view
        $articles = Article::paginate(24);

        return view('parent.articles', compact('articles', 'wishlist'));
    }
    // Add article to wishlist
    public function addArticle(Request $request)
    {
        // Find the wishlist with the id
        $wishlist = Wishlist::find($request->input('wishlist_id'));

        // Get all articles from the database and pass them to the view
        $articles = Article::paginate(24);

        // Add article to wishlist
        $wishlist->article_id = json_encode(array_merge(json_decode($wishlist->article_id), [$request->input('article_id')]));

        $wishlist->save();

        return redirect()->route('parent.wishlists.show')->with('success', 'Article added to wishlist successfully.');
    }

    // addItem
    public function addItem(Request $request)
    {
        // Find the wishlist with the id
        $wishlist = Wishlist::find($request->input('wishlist_id'));

        // Get all articles from the database and pass them to the view
        $articles = Article::paginate(24);

        // Add article to wishlist
        $wishlist->article_id = json_encode(array_merge(json_decode($wishlist->article_id), [$request->input('article_id')]));

        $wishlist->save();

        return redirect()->back()->with('success', 'Article added to wishlist successfully.');
    }
}
