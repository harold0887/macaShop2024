<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Illuminate\Support\Facades\Storage;

class PackageShow extends Component
{
    public $img, $title, $price;
    public $package, $productModal;

    public function mount($id)
    {

        $this->package = Package::where('slug', $id)
            ->firstOrFail();
    }
    public function render()
    {
        return view('livewire.package-show')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'package',
                'title' => $this->package->title,
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
    public function setProduct($id)
    {
        $this->reset(['productModal']);

        $this->productModal = Product::findOrFail($id);
        //$this->dispatch('membership-render-refresh')->self();


        $items = [];

        foreach ($this->productModal->items as $q) {
            $items[] = [
                'photo' => $q->photo,

            ];
        }





        $this->dispatch(
            'showProductDetails',
            title: $this->productModal->title,
            itemMain: $this->productModal->itemMain,
            items: $items,
        );
    }
}
