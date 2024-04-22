<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShowRender extends Component
{
    public $product, $articles;
    public $img, $title, $price;
    public $newComment;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    protected $rules = [
        'newComment' => 'required|string',
    ];
    protected $messages = [
        'newComment.required' => 'El comentario no puede estar vacío.',
    ];

    public function mount($id)
    {
        $this->product = Product::where('slug', $id)
            ->firstOrFail();

        $this->articles = Product::where('grade', '=', $this->product->grade)
            ->orderBy('title')
            ->where('price', '>', 0)
            ->whereNotIn('title', ['newsDesktop', 'newsMobile'])
            ->where('status', true)
            ->whereNotIn('id', [$this->product->id])
            ->take(5)
            ->get();
    }
    public function render()
    {



        return view('livewire.show-render')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'shop',
                'title' => $this->product->title,
                'navbarClass' => 'text-primary',
                'background' => '#eee !important'
            ])

            ->section('content');
    }


    public function addComment()
    {

        $this->validate();


        try {
            Comment::create([
                'comment' => $this->newComment,
                'product_id' => $this->product->id,
                'user_id' => Auth::user()->id,
                'best' => false,
            ]);



            $this->dispatch('alertComment', message: "<span class='text-sm'><b>Gracias !</b> - Su comentario fue registrado correctamentes.</span>");
        } catch (\Throwable $th) {
            $this->dispatch('error', message: 'Error al guardar el comentario - ' . $th->getMessage());
        }


        //$this->emit('refreshComponent');

        $this->newComment = "";
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
                    return Storage::download('public/' . $product->document, $product->name);
                } catch (\Throwable $th) {
                    $this->dispatch('error', message: 'Error al descargar el documento - ' . $th->getMessage());
                }
            }
        } else {
            $this->dispatch('alertlogin', message: "<span class='text-sm'><b>Importante !</b> - Registrate o inicia sesión para descargar este y otros materiales gratuitos. </span>");
        }
    }
}
