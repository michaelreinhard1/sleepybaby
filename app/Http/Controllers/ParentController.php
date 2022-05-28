<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParentController extends Controller
{
    public function show()
    {
        // Get all articles from the database and pass them to the view
        $articles = Article::paginate(24);

        return view('parent.wishlist.show', ['articles' => $articles]);
    }
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

    // addItem
    public function addItem(Request $request)
    {
        // Find the wishlist with the id
        $wishlist = Wishlist::find($request->input('wishlist_id'));

        // Add article to wishlist
        $wishlist->articles = json_encode(array_merge(json_decode($wishlist->articles), [$request->input('article')]));

        $wishlist->save();

        return redirect()->back()->with('success', __('Article added to wishlist successfully'));
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
            $share_link = 'http://localhost:8000' . '/share/' . $code;
        } else {
            // return url
            $share_link = env('APP_URL') . '/share/' . $code;
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
            $share_link = 'http://localhost:8000' . '/share/' . $code;
        } else {
            // return url
            $share_link = env('APP_URL') . '/share/' . $code;
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

        $orders_by_code = [];
        foreach ($orders as $order) {
            $orders_by_code[$order->code][] = $order;
        }

        // Add the wishlist nanem to orders_by_code as first element
        foreach ($orders_by_code as $code => $order) {
            $wishlist = Wishlist::where('code', $code)->first();
            $orders_by_code[$code][0]->wishlist_name = $wishlist->name;
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
}
