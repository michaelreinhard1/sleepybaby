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
        $user_id = random_int(10000, 99999);

        session()->put('code', $code);
        session()->put('user_id', $user_id);

        return $this->enterWithCode($code);

    }

    public function enterWithCode($code)
    {
        // Only redirect if the code is in wishlists
        if (Wishlist::where('code', $code)->exists()) {
            session()->put('code', $code);
            $user_id = random_int(10000, 99999);
            session()->put('user_id', $user_id);

            return redirect()->route('user.articles', $code);
        }
        else {
            return redirect()->route('invitation.show')->with('error', __('This code is invalid'));
        }
    }
}
