<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $allPosts = DB::table('posts')
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->select('posts.*', 'users.id as userId', 'users.fname', 'users.lname','users.email')
                    ->get();

        return view('index', [
            'allPosts' => $allPosts,
            'userInfo' => Auth::user()
        ]);
    }
}
