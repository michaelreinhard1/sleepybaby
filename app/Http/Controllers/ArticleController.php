<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Wishlist;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\View;

class ArticleController extends Controller
{

    public function show()
    {

        // Get code from local storage
        $code = session()->get('code');

        $wishlist = Wishlist::where('code', $code)->get();

        // Get all articles with id in wishlist->articles
        $articles = Article::whereIn('id', json_decode($wishlist[0]->articles))->paginate(24);

        // Get all the categories from the articles
        $categories = $articles->pluck('category')->unique();

        // Only pass the category the user has selected
        $selectedCategory = request()->category;

        return view('user.articles', compact('code', 'articles', 'wishlist'));

    }

    public function store(Request $request)
    {
        $article = Article::find($request->id);
        $user_id = session()->get('user_id');

        // If the article is already in the cart update the quantity
        if (Cart::get($article->id)) {
            Cart::session($user_id)->update($article->id,[
                'quantity' => +1,
            ]);
        } else {
            Cart::session($user_id)->add(array(
                'id' => $article->id,
                'name' => $article->title,
                'price' => $article->price,
                'quantity' => 1,
                'attributes' => array(
                    'image' => $article->image,
                    'description' => $article->description
                ),
                'associatedModel' => $article
            ));
        }

        // Redirect to articles page with success message
        return redirect()->back()->with('success', __('Article added to cart'));

    }

    public function showCart()
    {
        $user_id = session()->get('user_id');
        $cart = Cart::session($user_id);

        $cartItems = $cart->getContent();

        return view('user.cart', compact('cartItems'));
    }

    public function remove(Request $request)
    {
        // $article = Article::find($request->id);
        $user_id = session()->get('user_id');
        Cart::session($user_id)->remove($request->id);

        return redirect()->back()->with('success', __('Article removed from cart'));
    }

    // Add quantity to an item in the cart
    public function addItem(Request $request)
    {
        $article = Article::find($request->id);
        $user_id = session()->get('user_id');
        Cart::session($user_id)->update($article->id,[
            'quantity' => +1,
        ]);

        return redirect()->back()->with('success', __('Article quantity updated'));
    }

    // Remove quantity from an item in the cart
    public function removeItem(Request $request)
    {
        $article = Article::find($request->id);
        $user_id = session()->get('user_id');
        // If quantity is 1, remove the item from the cart
        if (Cart::session($user_id)->get($article->id)->quantity == 1) {
            Cart::session($user_id)->remove($article->id);
        } else {
            Cart::session($user_id)->update($article->id,[
                'quantity' => -1,
            ]);
        }

        return redirect()->back()->with('success', __('Article quantity updated'));
    }
}
