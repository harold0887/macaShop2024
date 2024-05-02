<?php

namespace App\Http\Controllers;

use App\Models\Ips;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Mchev\Banhammer\IP;
use Illuminate\Http\Request;
use App\Models\Order_Details;
use App\Mail\PaymentApprovedEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentApprovedMembership;

class MainController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->get('term');

        $query = Product::where('title', 'LIKE', '%' . $term . '%')
            ->orderBy('title')
            ->get();

        $data = [];

        foreach ($query as $q) {
            $data[] = [
                'label' => $q->title,
                'value' => $q->slug
            ];
        }
        return $data;
    }


    public function customerOrders(Request $request)
    {
        $this->saveIP($request, "Orders");

        $orders = Order::where('customer_id', Auth::user()->id)
            ->orderByDesc('created_at', 'desc')
            ->get();
        return view('account.account-orders', compact('orders'));
    }


    public function customerPackages(Request $request)
    {
        $this->saveIP($request, "Mis Paquetes");

        $packages = Order_Details::whereHas('order', function ($query) {
            $query->where('orders.customer_id', Auth::user()->id)
                ->where('orders.status', 'approved');
        })->where('order_details.package_id', '!=', null)
            ->get();

        return view('account.account-packages', compact('packages'));
    }

    public function customerMemberships(Request $request)
    {
        $this->saveIP($request, "Mis Membresías");

        $memberships = Order_Details::whereHas('order', function ($query) {
            $query->where('orders.customer_id', Auth::user()->id)
                ->where('orders.status', 'approved');
        })->where('order_details.membership_id', '!=', null)
            ->orderByDesc('created_at')
            ->get();

        return view('account.account-memberships', compact('memberships'));
    }

    public function createOrder()
    {

        $orderActive = true; //Iniciar la order como active, solo se desactiva si es membresía, paquete o producto con folio y si ya tiene whatsApp

        $newOrder = Order::create([
            'customer_id' => Auth::user()->id,
            'amount' => \Cart::getTotal(),
            'status' => 'create',

        ]);



        foreach (\Cart::getContent() as $item) {
            if ($item->associatedModel->model == 'Membership') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'membership_id' => $item->id,
                    'price' => $item->price,
                ]);
                $orderActive = false;
            } elseif ($item->associatedModel->model == 'Package') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'package_id' => $item->id,
                    'price' => $item->price,
                ]);
                if ($newOrder->user->whatsapp == null) {
                    $orderActive = false;
                }
            } elseif ($item->associatedModel->model == 'Product') {
                Order_Details::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->id,
                    'price' => $item->price,
                ]);
                if ($item->associatedModel->folio == 1 && $newOrder->user->whatsapp == null) {
                    $orderActive = false;
                }
            }
        }


        //Actualizar status de orden
        Order::findOrFail($newOrder->id)->update([
            'active' => $orderActive,
        ]);

        \Cart::clear();



        return redirect()->route('order.show', [$newOrder->id])->with('createSuccessOrder','order create success');
    }

    //envios reales pagina web

    public function thanks_you() //Metodo al que retorna al finalizar la compra real
    {

        //obtener la order
        $order = Order::findOrFail(request('external_reference'));
        switch (request('status')) {
            case 'approved':


                // //Actualizar status de orden
                // $order->update([
                //     'status' => "approved",
                //     'payment_id' => request('payment_id')
                // ]);

                // //Esto es nuevo
                // $products = Order_Details::where('order_id', $order->id)->where('product_id', '!=', null)->get();
                // $packages = Order_Details::where('order_id', $order->id)->where('package_id', '!=', null)->get();
                // $membreships = Order_Details::where('order_id', $order->id)->where('membership_id', '!=', null)->get();
                // $materialesComprados = false; //iniciar en falso, por que no sabemos que inlcuye la orden
                // //Si incluye productos o paquetes, se cambia a true para enviar email de compra
                // if ($products->count() > 0 || $packages->count() > 0) {
                //     $materialesComprados = true;
                // }
                // //enviar correo de materiales
                // if ($materialesComprados) {
                //     $notificacion = new PaymentApprovedEmail($order);
                //     Mail::to($order->user->email) //enviar correo al cliente
                //         ->send($notificacion);
                // }

                // //enviar correo de membresias
                // foreach ($membreships as $membresia) {
                //     $correoCopia = new PaymentApprovedMembership($membresia->membership_id, $order);
                //     Mail::to($order->user->email)
                //         ->send($correoCopia);
                // }


                return redirect()->route('order.show', [$order->id])->with('paySuccess', 'El pago ha sido realizado con éxito.');
                break;
            case 'pending':
                return redirect()->route('order.show', [$order->id])->with('payPending', 'El pago está  en proceso de validación.');
                break;
            case 'in_process':
                return redirect()->route('order.show', [$order->id])->with('payInProccess', 'El pago está  en proceso de validación para garantizar la total seguridad de la transacción.');
                break;
            case 'failure':
                return redirect()->route('order.show', [$order->id])->with('error', 'Tu compra no se pudo realizar.');
                break;
            default:
                return redirect()->route('order.show', [$order->id])->with('error', 'Ocurrio un error al procesar tu compra');
                break;
        }
    }


    public function createSales(User $user)
    {
        //return $user;

        //obtener la ultima compra
        //$lastOrder = Order::latest()->first();

        //dd($lastOrder);

        try {

            $newOrder = Order::create([
                'customer_id' => $user->id,
                'amount' => 0,
                'status' => 'approved',
                'payment_type' => 'Externo',
                //'payment_id' => $lastOrder->id + 1,
                //'order_id' => $lastOrder->id + 1,
                'active' => false,
            ]);

            return redirect()->to('dashboard/sales/' . $newOrder->id . '/edit')->with('success-auto-close', 'La orden fue creada con éxito');

            //return back()->with('success', 'Registro exitoso');
        } catch (\Throwable $e) {
            return back()->with('error', 'Error al guardar el registro - ' .  $e->getMessage());
        }
    }


    public function terminos()
    {
        return view('terminos');
    }
    public function aviso()
    {
        return view('aviso');
    }
    public function questions()
    {
        return view('questions');
    }
    public function contact()
    {
        return view('contact');
    }







    public function saveIP(Request $request, $setType)
    {
        $userIps = Ips::where('user_id', Auth::user()->id)
            ->where('ip', $request->ip())->get();

        if ($userIps->count() == null) {
            Ips::create([
                'user_id' => Auth::user()->id,
                'ip' => $request->ip(),
                'tipo' => $setType,
                'last_entry' => now(),
                'last_type' => $setType,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {

            foreach ($userIps as $ip) {
                Ips::findOrFail($ip->id)->update([
                    'last_entry' => now(),
                    'last_type' => $setType
                ]);
            }
        }
    }
}
