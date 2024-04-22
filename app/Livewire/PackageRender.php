<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class PackageRender extends Component
{
    use WithPagination;
    public $search = '';
    public $categoriesSelect = [];
    public $gradeSelect = [];
    public $img, $title, $price;
    protected $paginationTheme = 'bootstrap';

    public $icon, $showFilter, $showCategory, $collapseCategory, $showGrade, $collapseGrade;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $packages = Package::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
            //->orWhere('information', 'like', '%' . $this->search . '%');
        })->where('price', '>', 0)
            ->where('status',  true)
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        return view('livewire.package-render', compact('packages'))
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'package',
                'title' => "Paquetes",
                'navbarClass' => 'text-primary',
                'background' => '#eee !important',

            ])

            ->section('content');
    }


    public function clearSearch()
    {
        $this->reset(['search']);
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
