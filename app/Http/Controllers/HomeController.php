<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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

    public function mantenimiento()
    {
        $newsMobile = Product::where('title', 'newsMobile')
            ->first();
        $newsDesktop = Product::where('title', 'newsDesktop')
            ->first();
        $comments = Comment::where('best', 1)
            ->where('status', 1)->get();

        return view('mantenimiento', compact('newsMobile', 'newsDesktop', 'comments'));
    }


    public function dashboard()
    {
        return view('dashboard');
    }
    public function routes()
    {
        return view('admin.support-routes');
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

    public function storagePersonal()
    {
        try {
            $target = '/home3/materi65/shop2024/storage/app/public';
            $link =   '/home3/materi65/public_html/storage';
            symlink($target, $link);
            return back()->with('success', 'storage link personal create success');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al crear el storage link personal - ' . $th->getMessage());
        }
    }
    public function storageMain()
    {
        try {
            Artisan::call('storage:link');
            return back()->with('success', 'storage link main create success');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al crear el storage link - ' . $th->getMessage());
        }
    }
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            return back()->with('success', 'Application cache has been cleared');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al crear el storage link - ' . $th->getMessage());
        }
    }


    public function viewCler()
    {
        try {
            Artisan::call('view:clear');
            return back()->with('success', 'View cache has been cleared');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al crear el storage link - ' . $th->getMessage());
        }
    }
    public function showMemembershipSales($id)
    {
        $membership = Membership::withCount(['sales' => function ($query) {
            $query->whereHas('order', function ($query) {
                $query
                    ->where('status', 'approved')
                    ->whereNotIn('customer_id', [1, 5, 8218]);
                // ->where('payment_type', '!=', 'externo');
            });
        }])->findOrFail($id);




        return view('admin.membership.show-sales', compact('membership'));
    }
}
