<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // show homepage
    public function show()
    {
        return view('user.articles');
    }
}
