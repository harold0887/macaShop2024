<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Illuminate\Support\Facades\Storage;

class AsistenciaDemoRender extends Component
{
    public $membership;
    public $img, $title, $price;

    public function mount()
    {
        $this->membership = Membership::findOrFail(2013);
    }

    public function render()
    {
        return view('livewire.asistencia-demo-render')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'asistencia',
                'title' => "Asistencia",
                'pageBackground' => asset("material") . '/img/login.jpg',
                'navbarClass' => 'text-primary ',
                'background' => '#eee !important'
            ])

            ->section('content');
    }

    public function addCart($id, $model)
    {
        try {
            if ($model == "Product") {
                $product = Product::find($id);
            }
            if ($model == "Package") {
                $product = Package::find($id);
            }
            if ($model == "Membership") {
                $product = Membership::find($id);
            }


            \Cart::add(array(
                'id' => $product->id,
                'name' => $product->title,
                'price' => $product->price_with_discount,
                'quantity' => 1,
                'attributes' => array(
                    'type' => 'Membership',
                ),
                'associatedModel' => $product
            ));



            $this->img = Storage::url($product->itemMain);
            $this->title = $product->title;
            $this->price = $product->price_with_discount;




            $this->dispatch('cart:update');

            $this->dispatch(
                'addCartAlert',
                title: $this->title,
                price: $this->price . " MXN",
                img: $this->img
            );
        } catch (\Throwable $th) {
            $this->dispatch('error', message: "Error al agregar el producto al carrito - " . $th->getMessage());
        }
    }
    public function loginMessage()
    {
        $this->dispatch('alertlogin', message: "<span class='text-sm'><b>Importante !</b> - Inicia sesión o registrate para finalizar la compra. </span>");
    }
}
