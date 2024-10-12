<?php

namespace App\Livewire;

use App\Models\Grade;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Membership;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopRender extends Component
{
    use WithPagination, WithoutUrlPagination;


    public $img, $title, $price;
    protected $paginationTheme = 'bootstrap';
    public $membership, $productModal;



    public $filters = [
        'search' => '',
        'categorias' => [],
        'grados' => [],
    ];





    public function mount()
    {
        $this->membership = Membership::where('main', '=', 1)->first();
    }


    public function render()
    {
        //consultar y mostrar solo categorias que tengan al menos un producto
        $categories = Category::orderBy('name', 'ASC')
            ->select('name', 'id')
            ->whereNotIn('name', ['gratuito'])
            ->has('productsAll')
            ->get();

        $grados = Grade::orderBy('name', 'ASC')
            ->select('name', 'id')
            ->get();


        $products = Product::filter($this->filters)->paginate(39);



        return view('livewire.shop-render', compact('products', 'categories', 'grados'))
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'shop',
                'title' => "Tienda",
                'navbarClass' => 'text-primary',
                'pageBackground' => asset("material") . '/img/markus-spiske-187777.jpg',
                'background' => '#eee !important'
            ])

            ->section('content');
    }

    public function clearSearch()
    {
        $this->filters['search'] = '';
    }

    public function clearCategories()
    {
        $this->filters['categorias'] = [];
    }
    public function clearGrade()
    {
        $this->filters['grados'] = [];
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
