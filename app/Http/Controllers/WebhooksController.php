<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Mail\PruebasEmail;
use Illuminate\Http\Request;
use App\Models\Order_Details;
use App\Mail\PaymentApprovedEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentApprovedAsistencia;
use App\Mail\PaymentApprovedMembership;

class WebhooksController extends Controller
{
    public function __invoke(Request $request)
    {
        // Obtain the x-signature value from the header
        $xSignature = $_SERVER['HTTP_X_SIGNATURE'];
        $xRequestId = $_SERVER['HTTP_X_REQUEST_ID'];
        $idMP = $request["data"]["id"]; //obtener el id de Mercado Pago


        // Obtain Query params related to the request URL
        $queryParams = $_GET;

        // Extract the "data.id" from the query params
        $dataID = isset($queryParams['data.id']) ? $queryParams['data.id'] : '';

        // Separating the x-signature into parts
        $parts = explode(',', $xSignature);

        // Initializing variables to store ts and hash
        $ts = null;
        $hash = null;

        // Iterate over the values to obtain ts and v1
        foreach ($parts as $part) {
            // Split each part into key and value
            $keyValue = explode('=', $part, 2);
            if (count($keyValue) == 2) {
                $key = trim($keyValue[0]);
                $value = trim($keyValue[1]);
                if ($key === "ts") {
                    $ts = $value;
                } elseif ($key === "v1") {
                    $hash = $value;
                }
            }
        }

        // actualizar informacion de la orden y eviar notificaciones




        $ACCESS_TOKEN = config('services.mercadopago.token'); //aqui cargamos el token
        $curl = curl_init(); //iniciamos la funcion curl

        curl_setopt_array($curl, array(
            //ahora vamos a definir las opciones de conexion de curl
            CURLOPT_URL => "https://api.mercadopago.com/v1/payments/" . $idMP, //aqui iria el id de tu pago
            CURLOPT_CUSTOMREQUEST => "GET", // el metodo a usar, si mercadopago dice que es post, se cambia GET por POST.
            CURLOPT_RETURNTRANSFER => true, //esto es importante para que no imprima en pantalla y guarde el resultado en una variable
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $ACCESS_TOKEN
            ),
        ));



        $response = curl_exec($curl); //ejecutar CURL
        $response = json_decode($response, true); //a la respuesta obtenida de CURL la guardamos en una variable con formato json.


        $order = Order::findOrFail($response['external_reference']);




        //Actualizar status de orden
        $order->update([
            'status' => $response['status'],
            'payment_id' => $response['id'],
            'payment_type' => $response['payment_type_id'],
        ]);




        //Esto es nuevo
        $products = Order_Details::where('order_id', $order->id)->where('product_id', '!=', null)->get();
        $packages = Order_Details::where('order_id', $order->id)->where('package_id', '!=', null)->get();
        $membreships = Order_Details::where('order_id', $order->id)->where('membership_id', '!=', null)->get();
        $materialesComprados = false; //iniciar en falso, por que no sabemos que inlcuye la orden



        //Si incluye productos o paquetes, se cambia a true para enviar email de compra
        if ($products->count() > 0 || $packages->count() > 0) {
            $materialesComprados = true;
        }

        switch ($response['status']) {
            case 'approved':
                //enviar correo de materiales
                if ($materialesComprados) {
                    $confirmacionOrder = new PaymentApprovedEmail($order);
                    Mail::to($order->user->email) //enviar correo al cliente
                        ->send($confirmacionOrder);
                }

                //enviar correo de membresias
                foreach ($membreships as $membresia) {
                    if ($membresia->membership_id == 2013) {
                        //actualizar perfil de usuario
                        $user = User::findOrFail($order->user->id);
                        $user->update([
                            'pro' => true,
                        ]);
                        //enviar correo de lista de aistencia
                        $correoConfirmAsistencia = new PaymentApprovedAsistencia($membresia->membership_id, $order);
                        Mail::to($order->user->email)
                            ->send($correoConfirmAsistencia);
                    } else {
                        $correoCopia = new PaymentApprovedMembership($membresia->membership_id, $order);
                        Mail::to($order->user->email)
                            ->send($correoCopia);
                    }
                }
                break;
            case 'pending':
                break;
            case 'in_process':
                break;
            case 'failure':
                break;
            default:
                break;
        }
    }
}
