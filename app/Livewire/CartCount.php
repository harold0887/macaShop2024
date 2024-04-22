<?php

namespace App\Livewire;

use Livewire\Component;

class CartCount extends Component
{
    protected $listeners = [
        'cart:update' => '$refresh',
    ];
    public function render()
    {
        return view('livewire.cart-count');
    }
}
