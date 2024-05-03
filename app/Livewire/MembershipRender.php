<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Illuminate\Support\Facades\Storage;

class MembershipRender extends Component
{
    public $img, $title, $price;
    public function render()
    {

        $memberships = Membership::where('status', true)
            ->where('expiration', '>', now())
            ->orderBy('expiration','desc')
            ->get();

        return view('livewire.membership-render', compact('memberships'))
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'membership',
                'title' => "Membresía VIP",
                'navbarClass' => 'text-primary',
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
}
