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
    public $search = '';
    public $categoriesSelect = [];
    public $gradeSelect = [];
    public $img, $title, $price;
    protected $paginationTheme = 'bootstrap';
    public $membership;
    public $icon, $showFilter, $showCategory, $collapseCategory, $showGrade, $collapseGrade;





    public function mount()
    {
        $this->membership = Membership::where('main', '=', 1)->first();
    }


    public function render()
    {
        $busqueaCat = $this->categoriesSelect;
        $busqueaGra = $this->gradeSelect;
        $categories = Category::orderBy('name', 'ASC')
            ->select('name', 'id')
            ->whereNotIn('name', ['gratuito'])
            ->get();

        $degrees = Grade::orderBy('name', 'ASC')
            ->select('name', 'id')
            ->get();


        $products = Product::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('information', 'like', '%' . $this->search . '%');
        })->where('price', '>', 0)
            ->where('status',  true)
            ->orderBy('title', 'asc')
            ->whereNotIn('title', ['newsDesktop', 'newsMobile'])
            ->paginate(39);

     





        if (!empty($this->categoriesSelect)) {
            $products = Product::where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('information', 'like', '%' . $this->search . '%');
            })->where('price', '>', 0)
                ->where('status',  true)
                ->orderBy('created_at', 'desc')
                ->whereHas('categorias', function ($query) use ($busqueaCat) {
                    $query->whereIn('categories.id', $busqueaCat);
                })
                ->whereNotIn('title', ['newsDesktop', 'newsMobile'])
                ->paginate(40);
        }

        if (!empty($this->gradeSelect)) {
            $products = Product::where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('information', 'like', '%' . $this->search . '%');
            })->where('price', '>', 0)
                ->where('status',  true)
                ->orderBy('created_at', 'desc')
                ->whereIn('grade',  $this->gradeSelect)
                ->whereNotIn('title', ['newsDesktop', 'newsMobile'])
                ->paginate(40);
        }

        if (!empty($this->categoriesSelect) && !empty($this->gradeSelect)) {
            $products = Product::where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('information', 'like', '%' . $this->search . '%');
            })->where('price', '>', 0)
                ->where('status',  true)
                ->orderBy('created_at', 'desc')
                ->whereIn('grade',  $this->gradeSelect)
                ->whereHas('categorias', function ($query) use ($busqueaCat) {
                    $query->whereIn('categories.id', $busqueaCat);
                })
                ->whereNotIn('title', ['newsDesktop', 'newsMobile'])
                ->paginate(40);
        }


        $this->resetPage();



        return view('livewire.shop-render', compact('products', 'categories', 'degrees'))
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
        $this->reset(['search']);
    }

    public function clearCategories()
    {
        $this->reset(['categoriesSelect']);
    }
    public function clearGrade()
    {
        $this->reset(['gradeSelect']);
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
