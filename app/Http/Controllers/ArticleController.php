<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class ArticleController extends Controller
{
    public function show()
    {
        // Get all the articles from the database
        $articles = Article::paginate(24);

        // Get all the categories from the articles
        $categories = $articles->pluck('category')->unique();

        // Only pass the category the user has selected
        $selectedCategory = request()->category;

        return view('articles', compact('articles', 'categories'));
    }

    public function store(Request $request)
    {
        $article = Article::find($request->id);

        // If the article is already in the cart update the quantity
        if (Cart::get($article->id)) {
            Cart::session(1)->update($article->id,[
                'quantity' => +1,
            ]);
        } else {
            Cart::session(1)->add(array(
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
        return redirect()->route('articles')->with('success', 'Article added to cart');

    }

    public function showCart()
    {
        $cart = Cart::session(1);

        $cartItems = $cart->getContent();

        return view('cart', compact('cartItems'));
    }

    public function remove(Request $request)
    {
        $article = Article::find($request->id);

        Cart::session(1)->remove($article->id);

        return redirect()->back()->with('success', 'Article removed from cart');
    }

    // Add quantity to an item in the cart
    public function addItem(Request $request)
    {
        $article = Article::find($request->id);

        Cart::session(1)->update($article->id,[
            'quantity' => +1,
        ]);

        return redirect()->back()->with('success', 'Article quantity updated');
    }

    // Remove quantity from an item in the cart
    public function removeItem(Request $request)
    {
        $article = Article::find($request->id);

        // If quantity is 1, remove the item from the cart
        if (Cart::session(1)->get($article->id)->quantity == 1) {
            Cart::session(1)->remove($article->id);
        } else {
            Cart::session(1)->update($article->id,[
                'quantity' => -1,
            ]);
        }

        return redirect()->back()->with('success', 'Article quantity updated');
    }
}
