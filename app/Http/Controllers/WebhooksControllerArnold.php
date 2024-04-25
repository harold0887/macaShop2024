<?php

namespace App\Http\Controllers;

use MercadoPago\SDK;
use MercadoPago\Plan;
use MercadoPago\Invoice;
use MercadoPago\Payment;
use App\Mail\PruebasEmail;
use Illuminate\Http\Request;
use MercadoPago\Subscription;
use Illuminate\Support\Facades\Mail;

class WebhooksControllerArnold extends Controller
{
    public function __invoke(Request $request)
    {

        return response()->json(['success' => 'success'], 200);
    }
}
