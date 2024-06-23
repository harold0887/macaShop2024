<?php

namespace App\Livewire\Admin;

use DateTime;
use App\Models\User;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use App\Models\Order_Details;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Request;

class SalesEdit extends Component
{
    protected $listeners = ['some-event2' => '$refresh'];
    public $order, $ids, $patch, $search = '', $contacto, $status, $mercadoPago, $facebook, $comentario, $link;
    public $suma;
    public $priceOrder;
    public $dateOrder;
    protected $rules = [
        'contacto' => ['required', 'string'],
        'facebook' => 'required|string',
        'priceOrder' => 'required|numeric',
    ];

    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];

        $this->order = Order::findOrFail($this->ids);
        $this->contacto = $this->order->user->whatsapp;
        $this->facebook = $this->order->user->facebook;
        $this->status = $this->order->status;
        $this->mercadoPago = $this->order->payment_id;
        $this->comentario = $this->order->contacto;
        $this->link = $this->order->link;
    }
    public function render()
    {
        $this->priceOrder = $this->order->amount;
        $this->dateOrder = (new DateTime($this->order->created_at))->format('Y-m-d');
        $products = Product::where('price', '>', 0)
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy('title')
            ->get();


        $packages = Package::where('status', true)
            ->where('price', '>', 0)
            ->orderBy('title')
            ->get();



        $memberships = Membership::where('status', true)
            ->where('price', '>', 0)
            ->orderBy('title')
            ->get();

        $productsIncluded = Order_Details::join('products', 'order_details.product_id', 'products.id')

            ->where('order_details.order_id', $this->order->id)
            ->select('products.title', 'products.id', 'products.itemMain', 'order_details.price')
            ->orderBy('title')
            ->get();



        $PackagesIcluded = Order_Details::join('packages', 'order_details.package_id', 'packages.id')

            ->where('order_details.order_id', $this->order->id)
            ->select('packages.title', 'packages.id', 'packages.itemMain', 'order_details.price')
            ->orderBy('title')
            ->get();



        $MembershipsIcluded = Order_Details::join('memberships', 'order_details.membership_id', 'memberships.id')

            ->where('order_details.order_id', $this->order->id)
            ->select('memberships.title', 'memberships.id', 'memberships.itemMain', 'order_details.price')
            ->orderBy('title')
            ->get();


        $sumaProductos = Order_Details::join('products', 'order_details.product_id', 'products.id')

            ->where('order_details.order_id', $this->order->id)
            ->sum('order_details.price');


        $sumaPackages = Order_Details::join('packages', 'order_details.package_id', 'packages.id')

            ->where('order_details.order_id', $this->order->id)
            ->sum('order_details.price');



        $sumaMembresias = Order_Details::join('memberships', 'order_details.membership_id', 'memberships.id')

            ->where('order_details.order_id', $this->order->id)
            ->sum('order_details.price');



        $this->suma = $sumaProductos + $sumaMembresias + $sumaPackages;

        $registroAsistenciaPro = Membership::findOrFail(2013);



        return view('livewire.admin.sales-edit', compact('products', 'packages', 'memberships', 'productsIncluded', 'MembershipsIcluded', 'PackagesIcluded', 'registroAsistenciaPro'))
            ->extends('layouts.app', [
                'title' => 'Ventas',
                'navbarClass' => 'navbar-transparent',
                'activePage' => 'sales',
            ])
            ->section('content');
    }


    public function addProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $this->order->products()->attach($id, [
                'price' => $product->price_with_discount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->order->update([
                'amount' => $this->order->amount + $product->price_with_discount,
            ]);

            $this->dispatch('success-auto-close', message: 'El producto se agrego de manera correcta');
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Error al agregar el producto a la orden' . $th->getMessage());
        }
    }
    public function removeProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $this->order->products()->detach($id);
            $this->order->update([
                'amount' => $this->order->amount - $product->price_with_discount,
            ]);

            $this->dispatch('success-auto-close', message: 'El producto se elimino de manera correcta');
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Error al agregar el producto a la orden' . $th->getMessage());
        }
    }


    public function addPackage($id)
    {
        try {
            $package = Package::findOrFail($id);
            $this->order->Packages()->attach($id, [
                'price' => $package->price_with_discount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->order->update([
                'amount' => $this->order->amount + $package->price_with_discount,
            ]);

            $this->dispatch('success-auto-close', message: 'El paquete se agrego de manera correcta');
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Error al agregar el paquete a la orden' . $th->getMessage());
        }
    }
    public function removePackage($id)
    {
        try {
            $package = Package::findOrFail($id);
            $this->order->Packages()->detach($id);
            $this->order->update([
                'amount' => $this->order->amount - $package->price_with_discount,
            ]);

            $this->dispatch('success-auto-close', message: 'El paquete se elimino de manera correcta');
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Error al agregar el paquete a la orden' . $th->getMessage());
        }
    }


    public function addMembership($id)
    {
        try {
            $membership = Membership::findOrFail($id);
            $this->order->Memberships()->attach($id, [
                'price' => $membership->price_with_discount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->order->update([
                'amount' => $this->order->amount + $membership->price_with_discount,
            ]);

            $this->dispatch('success-auto-close', message: 'La membresía se agrego de manera correcta');
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Error al agregar la membresía a la orden' . $th->getMessage());
        }
    }
    public function removeMembership($id)
    {
        try {
            $membership = Membership::findOrFail($id);
            $this->order->Memberships()->detach($id);
            $this->order->update([
                'amount' => $this->order->amount - $membership->price_with_discount,
            ]);

            $this->dispatch('success-auto-close', message: 'La membresía se elimino de manera correcta');
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Error al agregar la membresía a la orden' . $th->getMessage());
        }
    }

    public function clearSearch()
    {
        $this->reset(['search']);
    }

    public function save()
    {

        try {
            Order::findOrFail($this->order->id)->update([
                'status' => $this->status,
                'payment_id' => $this->mercadoPago,
                'contacto' => $this->comentario,
                'link' => $this->link,
                'amount' => $this->priceOrder,
                'created_at' => $this->dateOrder . now()->format('G:i:s'),
            ]);
            User::findOrFail($this->order->customer_id)->update([
                'whatsapp' => $this->contacto,
                'facebook' => $this->facebook,
            ]);
            $this->dispatch('success-auto-close', message: 'La orden fue actualizada de manera correcta');
            $this->dispatch('some-event2');
        } catch (QueryException $th) {
            $this->dispatch('error', message: 'Error al actualizar la orden' . $th->getMessage());
        }
    }


    public function activeOrder()
    {
        $venta = Order::findOrFail($this->order->id);

        try {

            $status = $venta->active;

            if ($status == false) {

                if ($this->order->memberships->count() > 0) {

                    $this->validate();
                } else {

                    $this->validate([
                        'contacto' => 'required|string',
                    ]);
                }
                if ($this->status == "approved") {
                    Order::findOrFail($this->order->id)->update([
                        'status' => $this->status,
                        'payment_id' => $this->mercadoPago,
                        'contacto' => $this->comentario,
                    ]);
                    User::findOrFail($this->order->customer_id)->update([
                        'whatsapp' =>  $this->contacto,
                        'facebook' => $this->facebook,

                    ]);
                    $venta->update([
                        'active' => $status = true,
                    ]);
                    $this->dispatch('success-auto-close', message: 'El status se cambio de manera correcta');
                } else {

                    $this->dispatch('error', message: 'El status debe ser approved para activar la orden');
                }
            } else {
                $venta->update([
                    'active' => $status = false,
                ]);
                $this->dispatch('success-auto-close', message: 'El status se cambio de manera correcta');
            }
        } catch (QueryException $e) {
            $this->dispatch('error', message: $e->getMessage());
        } finally {
            //$this->dispatch('some-event2');

        }
    }
}
