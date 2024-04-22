<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $newsMobile = Product::where('title', 'newsMobile')
            ->first();
        $newsDesktop = Product::where('title', 'newsDesktop')
            ->first();
        $comments = Comment::where('best', 1)
            ->where('status', 1)->get();

        return view('home', compact('newsMobile', 'newsDesktop', 'comments'));
    }

    public function dashboard()
    {
        return view('dashboard');
    }
    public function profile()
    {
        return view('profile.user-profile');
    }

    public function verifiedUsers()
    {
        $all = User::get();

        foreach ($all as $user) {
            set_time_limit(0);
            $user->update(
                [
                    'email_verified_at' => '2022-03-11 19:20:58'
                ]
            );
        }


        return "verified users all";
    }
        
    public function banned()
    {
        return view('banned');
    }
}
