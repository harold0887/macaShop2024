<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use PhpParser\Node\Expr\Cast\Object_;

class ShowPayment extends Component
{
    public $payment, $response;

    protected $rules = [
        'payment' => 'required',
    ];
    public function render()
    {
        return view('livewire.admin.show-payment');
    }

    public function submit()
    {
        $this->validate();
        try {
            $ACCESS_TOKEN = config('services.mercadopago.token'); //aqui cargamos el token
            $curl = curl_init(); //iniciamos la funcion curl
            curl_setopt_array($curl, array(
                //ahora vamos a definir las opciones de conexion de curl
                CURLOPT_URL => "https://api.mercadopago.com/v1/payments/" . $this->payment, //aqui iria el id de tu pago
                CURLOPT_CUSTOMREQUEST => "GET", // el metodo a usar, si mercadopago dice que es post, se cambia GET por POST.
                CURLOPT_RETURNTRANSFER => true, //esto es importante para que no imprima en pantalla y guarde el resultado en una variable
                CURLOPT_ENCODING => "",
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . "APP_USR-1396168196491507-110321-568e292721694b54f54b81b846887014-787241098"
                ),
            ));



            $response = curl_exec($curl); //ejecutar CURL

            $response = json_decode($response, true); //a la respuesta obtenida de CURL la guardamos en una variable con formato json.

            dd($response);
            $this->dispatch(
                'success-auto-close',
                title: 'Success!',
                message: 'La consulta del pago se realizo de manera correcta'
            );
        } catch (\Throwable $e) {
            $this->dispatch('error', message: 'Error al consultar el pago - ' . $e->getMessage());
        }
    }
}
