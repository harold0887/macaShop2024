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
    public function __invoke(Request $request)
    {


        SDK::setAccessToken("PROD_ACCESS_TOKEN");
        switch ($_POST["type"]) {
            case "payment":
                $payment = Payment::find_by_id($_POST["data"]["id"]);

                $correoPrueba = new PruebasEmail($payment);
                Mail::to("arnulfoacosta0887@gmail.com")
                    ->send($correoPrueba);
                break;
            case "plan":

                break;
            case "subscription":

                break;
            case "invoice":

                break;
            case "point_integration_wh":
                // $_POST contiene la informaciòn relacionada a la notificaciòn.
                break;
        }
    }
}
