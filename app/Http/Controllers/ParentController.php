<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Order;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class ParentController extends Controller
{

    // construct
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->id = auth()->user()->id;

            $this->wishlists = User::find($this->id)->wishlists;

            return $next($request);
        });

    }

    public function showWishlists()
    {

        $wishlists = $this->wishlists;

        foreach ($wishlists as $wishlist) {
            $wishlist->share = $this->generateShareUrl($wishlist->id);
        }

        return view('parent.wishlists', compact('wishlists'));
    }

    public function createWishlist()
    {
        return view('parent.wishlist-create');
    }

    public function storeWishlist(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $wishlist = new Wishlist();
        $wishlist->user_id = auth()->user()->id;
        $wishlist->name = $request->input('name');
        $wishlist->description = $request->input('description');
        $wishlist->articles = json_encode([]);

        $wishlist->code = random_int(10000, 99999);

        $wishlist->save();

        return redirect()->route('parent.wishlists.show')->with('success', __('Wishlist created successfully'));
    }

    public function destroyWishlist($id)
    {

        $wishlist = Wishlist::find($id);

        $wishlist->deleted = true;

        $wishlist->save();

        return redirect()->route('parent.wishlists.show')->with('success', __('Wishlist deleted successfully'));
    }

    public function showWishlist($id)
    {
        $wishlist = Wishlist::find($id);

        if (!$wishlist) {
            return redirect()->route('parent.wishlists.show')->with('error', __('Wishlist not found'));
        }

        if ($wishlist->user_id !== $this->id) {
            return redirect()->route('parent.wishlists.show')->with('error', __('Wishlist does not belong to you'));
        }
        $articles = Article::whereIn('id', json_decode($wishlist->articles))->get();

        $orders = Order::where('wishlist_id', $id)->get();

        $ordered_articles = [];

        foreach ($orders as $order) {
            $ordered_articles = array_merge($ordered_articles, json_decode($order->articles));
        }

        $ordered_articles = Article::whereIn('id', $ordered_articles)->get();

        // Add for each ordered_article a the order name
        foreach ($ordered_articles as $ordered_article) {
            $ordered_article->order_name = Order::where('wishlist_id', $id)->where('articles', 'like', '%' . $ordered_article->id . '%')->first()->name;
        }

        return view('parent.wishlist-detail', compact('wishlist', 'articles', 'ordered_articles'));
    }

    // showArticles
    public function showArticles(Request $request, $wishlist_id)
    {

        // get request input category
        $category = $request->input('category');
        $price = $request->input('price');

        // if category is not set, set it to all
        if (!$category) {
            $category = 'all';
        }

        // if price is not set, set it to all
        if (!$price) {
            $price = 'all';
        }

        $wishlist = Wishlist::find($wishlist_id);

        // if category is all, get all articles from wishlist
        if ($category == 'all' && $price == 'all') {
            $articles = Article::paginate(24);
        } else {
            // else get all articles from wishlist with the category and price lower or equal to the price
            $articles = Article::where('category', $category)->where('price', '<=', $price)->paginate(24);
        }

        $current_price = $price;

        $category_id = $category;

        $categories = Article::pluck('category', 'category_id')->unique();

        return view('parent.articles', compact('articles', 'wishlist', 'categories', 'category_id', 'current_price'));
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

        $wishlists = $this->wishlists->pluck('id');

        $orders = Order::whereIn('wishlist_id', $wishlists)->get();

        foreach ($orders as $order) {
            $order->wishlist_name = Wishlist::where('id', $order->wishlist_id)->first()->name;
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
        $order = Order::find($id);


        // if order wishlist_id is not in wishlists, redirect to orders
        if (!in_array($order->wishlist_id, $this->wishlists)) {
            return redirect()->route('parent.orders.show')->with('error', __('Order does not belong to you'));
        }

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
