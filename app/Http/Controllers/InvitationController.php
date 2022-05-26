<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function show()
    {

        if (Auth::check()) {
            return redirect()->route('parent.wishlists.show');
        }
        return view('invitation');
    }

    public function enter(Request $request)
    {
        $code = $request->input('code');

        // Only redirect if the code is in wishlists
        if (Wishlist::where('code', $code)->exists()) {
            // Save the code to the local storage
            session()->put('code', $code);

            return redirect()->route('user.articles', $code);
        }
        else {
            return redirect()->route('invitation.show')->with('error', 'This code is invalid.');
        }

    }

    public function enterWithCode($code)
    {
        // Only redirect if the code is in wishlists
        if (Wishlist::where('code', $code)->exists()) {
            session()->put('code', $code);

            return redirect()->route('user.articles', $code);
        }
        else {
            return redirect()->route('invitation.show')->with('error', 'This code is invalid.');
        }
    }
}
