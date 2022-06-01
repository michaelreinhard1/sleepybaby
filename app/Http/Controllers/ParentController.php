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

    public function showWishlists(Request $request)
    {

        $wishlists = $request->user()->wishlists->where('deleted', false);

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

        $request->user()->wishlists()->create([
            'name' => $request->name,
            'description' => $request->description,
            'articles' => '[]',
            'code' => $this->generateCode(),
        ]);

        return redirect()->route('parent.wishlists.show')->with('success', __('Wishlist created successfully'));
    }

    public function destroyWishlist(Wishlist $wishlist)
    {

        $wishlist->deleted = true;

        $wishlist->save();

        return redirect()->route('parent.wishlists.show')->with('success', __('Wishlist deleted successfully'));
    }

    public function showWishlist(Wishlist $wishlist, Order $order)
    {

        $wishlist->share = $this->generateShareUrl($wishlist->id);

        $orders = $wishlist->orders;

        $ordered_articles = [];

        foreach ($orders as $order) {
            $order->articles = json_decode($order->articles);
            // get articles from order
            $order->articles = Article::whereIn('id', $order->articles)->get();
            $ordered_articles = array_merge($ordered_articles, json_decode($order->articles));
        }

        foreach ($ordered_articles as $ordered_article) {
            $ordered_article->order_name = $order->name;
        }

        $articles = json_decode($wishlist->articles);

        $articles = Article::whereIn('id', $articles)->get();

        return view('parent.wishlist-detail', compact('wishlist', 'articles', 'ordered_articles'));

    }

    // showArticles
    public function showArticles(Request $request, Wishlist $wishlist)
    {

        // get request input category
        $category = $request->input('category');
        $price = $request->input('price');
        $price = floatval($price);


        // if ($category && $price ) {
        //     $articles = Article::whereBetween('price', [0, $price])->where('category_id', $category)->get();
        // }
        // elseif ($category) {
        //     $articles = Article::where('category_id', $category)->get();
        // }
        // elseif ($price) {
        //     $articles = Article::whereBetween('price', [0, $price])->get();
        // }
        // else {
        //     $articles = Article::all();
        // }

        // also get all articles if no category or price is selected


        $articles = Article::whereHas('category', function ($query) use ($category, $price) {
            if ($category && !$price) {
                $query->where('category_id', $category);
            }
            elseif (!$category && $price) {
                $query->whereBetween('price', [0, $price]);
            }
            elseif ($category && $price) {
                $query->where('category_id', $category)->whereBetween('price', [0, $price]);
            }
        })->paginate(24);

        $current_price = $price;

        $category_id = $category;

        $categories = Article::pluck('category', 'category_id')->unique();

        $articles->appends(['category' => $category_id, 'price' => $current_price]);

        return view('parent.articles', compact('articles', 'wishlist', 'categories'));
    }

    public function addItem(Request $request)
    {
        $wishlist = Wishlist::find($request->input('wishlist_id'));

        $wishlist->articles = json_encode(array_merge(json_decode($wishlist->articles), [$request->input('article')]));

        $wishlist->save();

        return redirect()->back()->with('success', __('Article added to wishlist successfully'));

    }

    public function removeItem(Request $request)
    {
        $wishlist = Wishlist::find($request->input('wishlist_id'));

        $wishlist->articles = json_encode(array_values(array_diff(json_decode($wishlist->articles), [$request->input('article')])));

        $wishlist->save();

        return redirect()->back()->with('success', __('Article removed from wishlist successfully'));
    }

    private function generateCode()
    {
        return random_int(10000, 99999);;
    }

    private function generateShareUrl($id)
    {
        $wishlist = Wishlist::find($id);

        $code = $wishlist->code;

        $share_link = env('APP_URL') . '/list/' . $code;

        return $share_link;
    }


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

    public function showOrder($id)
    {

        $order = Order::find($id);

        $wishlist_id = $order->wishlist_id;

        $user_id = Wishlist::find($wishlist_id)->user_id;

        if ($user_id !== $this->id) {
            return redirect()->route('parent.orders.show')->with('error', __('Order does not belong to you'));
        }


        $articles = Article::whereIn('id', json_decode($order->articles))->paginate(24);

        return view('parent.order-detail', compact('order', 'articles'));
    }

    public function downloadPDF($id)
    {
        $wishlist = Wishlist::find($id);

        $share_url = $this->generateShareUrl($id);

        $articles = Article::whereIn('id', json_decode($wishlist->articles))->get();

        $pdf = PDF::loadView('parent.wishlist-detail-pdf', compact('wishlist', 'articles', 'share_url'));

        return $pdf->download('wishlist.pdf');
    }
}
