<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function show()
    {
        return view('invitation');
    }
}
