<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class ParentController extends Controller
{


    // showWishlist
    public function showWishlists()
    {
        // show wishlist of the user only if deleted is false
        $wishlists = Wishlist::where('user_id', auth()->user()->id)->where('deleted', false)->paginate(24);

        foreach ($wishlists as $wishlist) {
            $wishlist->share = $this->generateShareUrl($wishlist->id);
        }

        return view('parent.wishlists', compact('wishlists'));
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

        // Validating the data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // Store the new wishlist in the database
        $wishlist = new Wishlist();
        $wishlist->user_id = auth()->user()->id;
        $wishlist->name = $request->input('name');
        $wishlist->description = $request->input('description');
        $wishlist->articles = json_encode([]);

        // generate a unique number for the code
        $wishlist->code = random_int(10000, 99999);

        $wishlist->save();

        return redirect()->route('parent.wishlists.show')->with('success', __('Wishlist created successfully'));
    }

    public function destroyWishlist($id)
    {

        // Set wishlist deleted to true
        $wishlist = Wishlist::find($id);

        $wishlist->deleted = true;

        $wishlist->save();

        return redirect()->route('parent.wishlists.show')->with('success', __('Wishlist deleted successfully'));
    }

    public function showWishlist($id)
    {

        // Find the wishlist with the id
        $wishlist = Wishlist::find($id);


        // Get all articles with id in wishlist->articles
        $articles = Article::whereIn('id', json_decode($wishlist->articles))->get();

        // get articles from orders with same code as wishlist->code
        $orders = Order::where('code', $wishlist->code)->get();

        $ordered_articles = [];

        foreach ($orders as $order) {
            $ordered_articles = array_merge($ordered_articles, json_decode($order->articles));
        }

        $ordered_articles = Article::whereIn('id', $ordered_articles)->get();

        // Add for each ordered_article a the order name
        foreach ($ordered_articles as $ordered_article) {
            $ordered_article->order_name = Order::where('code', $wishlist->code)->where('articles', 'like', '%' . $ordered_article->id . '%')->first()->name;
        }

        return view('parent.wishlist-detail', compact('wishlist', 'articles', 'ordered_articles'));
    }

    // showArticles
    public function showArticles(Request $request, $wishlist_id)
    {

        // get request input category
        $category = $request->input('category');

        // if category is not set, set it to all
        if (!$category) {
            $category = 'all';
        }

        $wishlist = Wishlist::find($wishlist_id);

        // if category is all, get all articles from wishlist
        if ($category == 'all') {
            $articles = Article::paginate(24);
        } else {
            // else get all articles from wishlist with the category
            $articles = Article::where('category_id', $category)->paginate(24);
        }

        $category_id = $category;

        $categories = Article::pluck('category', 'category_id')->unique();

        return view('parent.articles', compact('articles', 'wishlist', 'categories', 'category_id'));
    }

    // addItem
    public function addItem(Request $request)
    {
        // Find the wishlist with the id
        $wishlist = Wishlist::find($request->input('wishlist_id'));

        // Add article to wishlist
        $wishlist->articles = json_encode(array_merge(json_decode($wishlist->articles), [$request->input('article')]));

        $wishlist->save();

        return redirect()->back()->with('success', __('Article added to wishlist successfully'));
        // return redirect(url()->previous().'#article'.$request->input('article'));

    }

    // removeItem
    public function removeItem(Request $request)
    {
        // Find the wishlist with the id
        $wishlist = Wishlist::find($request->input('wishlist_id'));

        // Remove article from wishlist
        $wishlist->articles = json_encode(array_values(array_diff(json_decode($wishlist->articles), [$request->input('article')])));

        $wishlist->save();

        return redirect()->back()->with('success', __('Article removed from wishlist successfully'));
    }

    // share
    private function generateShareUrl($id)
    {
        // Find the wishlist with the id
        $wishlist = Wishlist::find($id);

        // get code
        $code = $wishlist->code;

        // if env is local
        if (env('APP_ENV') == 'local') {
            // return url
            $share_link = 'http://localhost:8000' . '/list/' . $code;
        } else {
            // return url
            $share_link = env('APP_URL') . '/list/' . $code;
        }

        return $share_link;
    }

    // copyToClipboard
    public function copyToClipboard($id)
    {
        // Find the wishlist with the id
        $wishlist = Wishlist::find($id);

        // get code
        $code = $wishlist->code;

        // if env is local
        if (env('APP_ENV') == 'local') {
            // return url
            $share_link = 'http://localhost:8000' . '/list/' . $code;
        } else {
            // return url
            $share_link = env('APP_URL') . '/list/' . $code;
        }

        // copy to clipboard
        $this->copyToClipboard($share_link);

        return redirect()->back()->with('success', __('Link copied to clipboard'));
    }

    // showOrders
    public function showOrders()
    {

        $wishlists = Wishlist::where('user_id', auth()->user()->id)->get();

        $orders = Order::whereIn('code', $wishlists->pluck('code'))->paginate(24);

        // get the wishlist names
        foreach ($orders as $order) {
            $order->wishlist_name = Wishlist::where('code', $order->code)->first()->name;
        }

        $orders_by_code = [];
        foreach ($orders as $order) {
            $orders_by_code[$order->wishlist_name][] = $order;
        }

        return view('parent.orders', compact('orders_by_code'));
    }
    // showOrder
    public function showOrder($id)
    {
        // Find the order with the id
        $order = Order::find($id);

        $articles = Article::whereIn('id', json_decode($order->articles))->paginate(24);

        return view('parent.order-detail', compact('order', 'articles'));
    }
    // downloadPDF
    public function downloadPDF($id)
    {
        // Find the order with the id
        $wishlist = Wishlist::find($id);

        $share_url = $this->generateShareUrl($id);

        $articles = Article::whereIn('id', json_decode($wishlist->articles))->get();

        $pdf = PDF::loadView('parent.wishlist-detail-pdf', compact('wishlist', 'articles', 'share_url'));

        return $pdf->download('wishlist.pdf');
    }
}
