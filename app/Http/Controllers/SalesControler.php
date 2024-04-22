<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;

use Illuminate\Http\Request;
use App\Models\Order_Details;
use Illuminate\Database\QueryException;

class SalesControler extends Controller
{
    public function index()
    {
        return view('admin.sales.index');
    }


    public function create()
    {
        $users = User::all();
        return view('admin.sales.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'order' => 'required',
            'price' => 'required',
            'user' => 'required',

        ]);

        //obtener al comprador
        $customer = User::findOrFail(request('user'));
        try {

            $newOrder = Order::create([
                'customer_id' => $customer->id,
                'amount' => request('price'),
                'status' => 'approved',
                'payment_type' => 'mercado_pago',
                'payment_id' => request('order'),
                'order_id' => request('order'),
                'active' => false,

            ]);


            return redirect()->to('dashboard/sales/' . $newOrder->id . '/edit')->with('success-auto-close', 'Registro exitoso');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al guardar el registro - ' .  $e->getMessage());
        }
    }


    public function show($id)
    {
        $order = Order::findOrFail($id);
        $purchases = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('order_details.order_id', $order->id)
            ->orderBy('products.title')
            ->select(
                'products.id',
                'products.itemMain',
                'order_details.price',
                'products.title',
            )
            ->get();


        $packages = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('packages', 'order_details.package_id', '=', 'packages.id')
            ->where('orders.id', $id)
            ->select(
                'packages.id',
                'packages.itemMain',
                'order_details.price',
                'packages.title',
            )->orderBy('packages.title')
            ->get();



        $memberships = Order_Details::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('memberships', 'order_details.membership_id', '=', 'memberships.id')
            ->where('orders.id', $id)
            ->select(
                'memberships.id',
                'memberships.itemMain',
                'order_details.price',
                'memberships.title',
            )->orderBy('memberships.title')
            ->get();



        return view('admin.sales.show', compact(
            'purchases',
            'packages',
            'memberships'
        ));
    }


    public function edit($id)
    {
        return view('admin.sales.edit');
    }


 
}
