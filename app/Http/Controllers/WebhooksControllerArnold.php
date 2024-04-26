<?php

namespace App\Http\Controllers;

use MercadoPago\SDK;
use App\Models\Order;
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

        $idMP = $request["data"]["id"]; //obtener el id de Mercado Pago


        $correoPrueba = new PruebasEmail($idMP);
        Mail::to("arnulfoacosta0887@gmail.com")
            ->send($correoPrueba);

        //obtener el pago completo en json
        $response = Http::get("https://api.mercadopago.com/v1/payments/$idMP" . "?access_token=APP_USR-2311547743825741-013023-3721797a3fbdf97bf2d4ff3f58000481-269113557");



        $response = json_decode($response);

        $order = Order::findOrFail($response->external_reference);




        //Actualizar status de orden
        $order->update([
            'status' => $response->status,
            'payment_id' => $response->id,
            'payment_type' => $response->payment_type_id,
        ]);
    }
}
