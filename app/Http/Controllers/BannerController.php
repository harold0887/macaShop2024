<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function index()
    {
        return view('admin.banner.index');
    }


    public function create()
    {
        return view('admin.banner.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'unique:banners'],
            'mobile' => 'required|image',
            'desktop' => 'required|image',


        ]);

        Banner::create([
            'title' => request('title'),
            'information' => '-',
            'desktop' => $request->desktop->store('banners', 'public'),
            'mobile' => $request->mobile->store('banners', 'public'),
            'status' => true
        ]);

        return back()->with('success', 'Registro exitoso');
    }
}
