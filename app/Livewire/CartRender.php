<?php

namespace App\Livewire;

use Livewire\Component;

class CartRender extends Component
{
    protected $listeners = [
        'cart-render-refresh' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.cart-render')
            ->extends('layouts.app', [
                'class' => 'off-canvas-sidebar',
                'classPage' => 'login-page',
                'activePage' => 'cart',
                'title' => "Carrito",
                'navbarClass' => 'text-primary',
                'background' => '#eee !important'
            ])

            ->section('content');
    }

    public function remove($id, $title)
    {
        try {
            \Cart::remove($id);
            $this->dispatch('cart:update');
            $this->dispatch('deleteCartAlert', message: $title . " se ha eliminado del carrito");



            $this->dispatch('cart-render-refresh')->self();
        } catch (\Throwable $th) {

            $this->dispatch('error', message: "Error al eliminar el producto " . $th->getMessage());
        }
    }


    public function loginMessage()
    {


        $this->dispatch('alertlogin', message: "<span class='text-sm'><b>Importante !</b> - Inicia sesión o registrate para finalizar la compra. </span>");
    }
}
