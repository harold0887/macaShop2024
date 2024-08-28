<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;

class SearchAdmin extends Component
{
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'id';
    public function render()
    {
        $orders = Order::query()
            ->with(['user'])
            ->when($this->search, function ($query) {
                $query->where('payment_id', 'like', '%' . trim($this->search) . '%')
                    ->orWhere('status', 'like', '%' . trim($this->search) . '%')
                    ->orWhere('order_id', 'like', '%' . trim($this->search) . '%')
                    ->orWhere('contacto', 'like', '%' . trim($this->search) . '%')
                    ->orWhere('id', 'like', '%' . trim($this->search) . '%');
            })
            ->orWhereHas('user', function ($query) {
                $query->where('email', 'like', '%' . trim($this->search) . '%')
                    ->orWhere('facebook', 'like', '%' . trim($this->search) . '%')
                    ->orWhere('whatsapp', 'like', '%' . trim($this->search) . '%');
            })->orderBy($this->sortField, $this->sortDirection)
            ->paginate(50);
        return view('livewire.admin.search-admin', compact('orders'));
    }
    public function clearSearch()
    {
        $this->reset(['search']);
    }
}
