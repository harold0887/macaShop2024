<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ips;
use App\Models\User;
use App\Models\Grupo;
use App\Models\Order;
use App\Models\Product;
use Mchev\Banhammer\IP;
use App\Models\Condicion;
use App\Models\Asistencia;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use App\Models\Order_Details;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\PaymentApprovedEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentApprovedAsistencia;
use App\Mail\PaymentApprovedMembership;
use App\Models\Membership;

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
                if ($item->associatedModel->id != 2013) {
                    $orderActive = false;
                }
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



        return redirect()->route('order.show', [$newOrder->id])->with('createSuccessOrder', 'order create success');
    }

    //envios reales pagina web

    public function thanks_you() //Metodo al que retorna al finalizar la compra real
    {

        //obtener la order
        $order = Order::findOrFail(request('external_reference'));
        switch (request('status')) {
            case 'approved':


                // //Actualizar status de orden
                $order->update([
                    'status' => "approved",
                    'payment_id' => request('payment_id')
                ]);

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
                //     if ($membresia->membership_id == 2013) {
                //         //actualizar perfil de usuario
                //         $user = User::findOrFail($order->user->id);
                //         $user->update([
                //             'pro' => true,
                //         ]);
                //         //enviar correo de lista de aistencia
                //         $correoConfirmAsistencia = new PaymentApprovedAsistencia($membresia->membership_id, $order);
                //         Mail::to($order->user->email)
                //             ->send($correoConfirmAsistencia);
                //     } else {
                //         $correoCopia = new PaymentApprovedMembership($membresia->membership_id, $order);
                //         Mail::to($order->user->email)
                //             ->send($correoCopia);
                //     }
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

    public function addStudent($id)
    {


        $group = Grupo::findOrFail($id);
        $alumnos = Estudiante::where('grupo_id', $group->id)->get();
        $condiciones = Condicion::all();


        if ($group->user_id == Auth::user()->id) {
            if (Auth::user()->pro || $alumnos->count() < 25) {
                return view('customer.estudiantes.add-student', compact('group', 'condiciones'));
            } else {
                return redirect()->route('grupos.index')->with('infoPro', 'La versión gratuita permite registrar máximo 25 alumnos, si necesita registrar más alumnos. Adquiera la versión PRO');
                //return back()->with('info', 'La versión gratuita permite registrar máximo 25 alumnos, si necesita registrar más alumnos.');
            }
        } else {
            abort(403);
        }
    }

    public function groupReport($id)
    {
        $group = Grupo::findOrFail($id);
        if ($group->user_id == Auth::id()) {
            return view('customer.reportes.group-report', compact('group'));
        } else {
            abort(403);
        }
    }
    public function groupReportExcel($id)
    {
        $group = Grupo::findOrFail($id);
        if ($group->user_id == Auth::id()) {
            return view('customer.reportes.group-report-excel', compact('group'));
        } else {
            abort(403);
        }
    }

    public function groupReportPDF($id)
    {
        //return view('customer.reportes.pdf');

        $group = Grupo::findOrFail($id);

        if ($group->id == 1) {
            $estudiantes = Estudiante::where('grupo_id', $group->id)
                ->orderBy('apellidos', 'asc')
                ->get();
        } else {
            $estudiantes = Estudiante::where('grupo_id', $group->id)
                ->whereHas('grupo', function ($query) {
                    $query
                        ->where('user_id', Auth::user()->id);
                })

                ->orderBy('apellidos', 'asc')
                ->get();
        }
        $asistencias = Asistencia::whereHas('estudiante', function ($query) {
            $query
                ->where('grupo_id', 1);
        })
            ->whereMonth('dia', 6)
            ->whereYear('dia', 2024)
            //       ->where('status_id', 1)
            ->get();


        $dt2 = Carbon::createFromDate('2024-06-01');



        $firstDay = $dt2->firstOfMonth()->format('d');
        $lastDay = $dt2->LastOfMonth()->format('d');


        $diasMes = [];

        for ($i = 0; $i < $lastDay; $i++) {

            $day = Carbon::create(2024, 06, 01)->addDays($i);

            if ($day->format('l') == 'Saturday' || $day->format('l') == 'Sunday') {
            } else {


                array_push($diasMes, $day);
            }
        }

        $monthSelectName = "Npmbre de prueba vista";
        $yearSelect = "2024";

        //return view('customer.reportes.pdf', compact('estudiantes', 'asistencias', 'firstDay', 'lastDay', 'diasMes'));


        try {
            $pdf = Pdf::loadView('customer.reportes.report-pdf', compact('estudiantes', 'asistencias', 'firstDay', 'lastDay', 'diasMes', 'monthSelectName', 'yearSelect'));
            //return $pdf->download('reporte.pdf');

            return view('customer.reportes.report-pdf', compact('estudiantes', 'asistencias', 'firstDay', 'lastDay', 'diasMes', 'monthSelectName', 'yearSelect'));
            //return $pdf->stream();
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al exportar el reporte - ' . $th->getMessage());
        };
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
