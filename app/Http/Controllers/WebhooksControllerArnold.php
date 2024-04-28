<?php

namespace App\Http\Controllers;


use MercadoPago\SDK;
use MercadoPago\Plan;
use MercadoPago\Invoice;
use MercadoPago\Payment;
use App\Mail\PruebasEmail;
use Illuminate\Http\Request;
use MercadoPago\Subscription;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentApprovedMembership;

class WebhooksControllerArnold extends Controller
{
    public function __invoke()
    {

        $payment = Payment::find_by_id($_POST["data"]["id"]);

        $correoPrueba = new PruebasEmail($payment);
        Mail::to("arnulfoacosta0887@gmail.com")
            ->send($correoPrueba);
    
    }
}
