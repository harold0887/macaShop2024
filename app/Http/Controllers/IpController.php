<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IpController extends Controller
{
    public function index()
    {
        return view('admin.ips.index');
    }
}
