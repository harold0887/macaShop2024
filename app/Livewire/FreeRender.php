<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FreeRender extends Component
{
    use WithPagination;
    public $search = '';
    public $membership;
    public $img, $title, $price;
    protected $paginationTheme = 'bootstrap';



    public function mount()
    {
        $this->membership = Membership::where('main', '=', 1)->first();
    }



    public function render()
    {

        $products = Product::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('information', 'like', '%' . $this->search . '%');
        })->where('price', '=', 0)
            ->orderBy('title')
            ->where('status',  true)
            ->orderBy('created_at', 'desc')
            ->whereNotIn('title', ['newsDesktop', 'newsMobile'])
            ->paginate(40);






        return view('livewire.free-render', compact('products'))
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'free',
                'title' => "Material gratuito",
                'navbarClass' => 'text-primary',
                'background' => '#eee !important'
            ])

            ->section('content');
    }





    public function downloadFree($id)
    {
        $product = Product::findOrFail($id);
        if (Auth::check()) {

            if ($product->price > 0) {
                return redirect(route('shop.show', $product->slug));
            } else {
                try {
                    DB::table('descargas')->insert([
                        'id_product' => $product->id,
                        'id_user' => Auth::user()->id,
                    ]);
                    $this->dispatch('alertDownload', message: "<span class='text-sm'><b>Importante !</b> - Si tiene problemas con la descarga, se recomienda descargar desde una computadora.</span>");
                    
                    //return Storage::download($product->document, $product->name);
                    $file = "./storage/" . $product->document;
                    return response()->download($file, $product->title . "." . $product->format);
                } catch (\Throwable $th) {
                    $this->dispatch('error', message: 'Error al descargar el documento - ' . $th->getMessage());
                  
                }
            }
        } else {
            $this->dispatch('alertlogin', message: "<span class='text-sm'><b>Importante !</b> - Inicia sesión o registrate para descargar este y otros materiales gratuitos. </span>");
        }
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
            $this->price = $product->price;




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
