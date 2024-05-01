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
        // Obtain the x-signature value from the header
        $xSignature = $_SERVER['HTTP_X_SIGNATURE'];
        $xRequestId = $_SERVER['HTTP_X_REQUEST_ID'];
        $payment = Payment::find_by_id($_POST["data"]["id"]); //obtener el id del pago

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

        // Obtain the secret key for the user/application from Mercadopago developers site
        $secret = "5b098a38b38e0e7eb92344be55e83adc84bb2701dc6d98c0f89d91cd81f38cc8";

        // Generate the manifest string
        $manifest = "id:$dataID;request-id:$xRequestId;ts:$ts;";

        // Create an HMAC signature defining the hash type and the key as a byte array
        $sha = hash_hmac('sha256', $manifest, $secret);
        if ($sha === $hash) {
            // HMAC verification passed
            echo "HMAC verification passed";
            $correoPrueba = new PruebasEmail($payment, "Paso la verificacion");
            Mail::to("arnulfoacosta0887@gmail.com")
                ->send($correoPrueba);


                
        } else {
            // HMAC verification failed
            echo "HMAC verification failed";
        }
    }
}
