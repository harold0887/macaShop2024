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

        SDK::setAccessToken("ENV_ACCESS_TOKEN");
        switch ($_POST["type"]) {
            case "payment":
                $payment = Payment::find_by_id($_POST["data"]["id"]);
                $sendEmailpruebas = new PruebasEmail($payment);
                Mail::to("harold0887@hotmail.com")
                    ->send($sendEmailpruebas);
                response()->json(['success' => 'success'], 200);
                break;
            case "plan":
                $plan = Plan::find_by_id($_POST["data"]["id"]);
                break;
            case "subscription":
                $plan = Subscription::find_by_id($_POST["data"]["id"]);
                break;
            case "invoice":
                $plan = Invoice::find_by_id($_POST["data"]["id"]);
                break;
            case "point_integration_wh":
                // $_POST contiene la informaciòn relacionada a la notificaciòn.
                break;
        }
        $idMP = $request["data"]["id"]; //obtener el id de Mercado Pago

        response()->json(['success' => 'success'], 200);
    }
}
