<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function show()
    {

        if (Auth::check()) {
            return redirect()->route('user.articles');
        }
        return view('invitation');
    }

    public function enter(Request $request)
    {
        $code = $request->input('code');




        return redirect()->route('user.articles');

        // $code = $request->input('code');

        // $article = Article::where('code', $code)->first();

        // if (!$article) {
        //     return redirect()->route('invitation.show')->with('error', 'Invalid code');
        // }

        // $article->users()->attach(auth()->user()->id);

        // return redirect()->route('articles.show')->with('success', 'You have successfully entered the code');
    }
}
