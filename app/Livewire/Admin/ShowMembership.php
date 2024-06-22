<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use App\Models\Membership;
use App\Models\Order_Details;
use Illuminate\Support\Facades\Request;

class ShowMembership extends Component
{
    public $patch, $ids, $membership;
    public $sortDirection = 'asc';
    public $sortField = 'created_at';
    public $filters = [
        'fromDate' => '',
        'toDate' => '',
    ];



    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[6];
        $this->membership = Membership::findOrFail($this->ids);
    }
    public function render()
    {

        $orders = Order_Details::filter($this->filters)
            ->where('membership_id', $this->membership->id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'approved')
                    ->whereNotIn('customer_id', [1, 5, 8218]);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $ingresos = Order_Details::filter($this->filters)
            ->where('membership_id', $this->membership->id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'approved')
                    ->whereNotIn('customer_id', [1, 5, 8218]);
            })->sum('price');

        $ingresosExternal = Order_Details::filter($this->filters)
            ->where('membership_id', $this->membership->id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'approved')
                    ->where('payment_type', 'Externo')
                    ->whereNotIn('customer_id', [1, 5, 8218]);
            })->sum('price');

        $ingresosWeb = Order_Details::filter($this->filters)
            ->where('membership_id', $this->membership->id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'approved')
                    ->where('payment_type', '!=', 'Externo')
                    ->whereNotIn('customer_id', [1, 5, 8218]);
            })->sum('price');

        $salesExterno = 0;
        $salesWeb = 0;

        foreach ($orders as $order) {
            if ($order->order->payment_type == 'Externo') {
                $salesExterno++;
            } else {
                $salesWeb++;
            }
        }



        return view('livewire.admin.show-membership', compact('orders', 'ingresos', 'salesExterno', 'salesWeb', 'ingresosExternal', 'ingresosWeb'));
    }
    //sort
    public function setSort($field)
    {

        $this->sortField = $field;

        if ($this->sortDirection == 'desc') {
            $this->sortDirection = 'asc';
        } else {
            $this->sortDirection = 'desc';
        }
    }
    public function clearSearch()
    {
        $this->reset(['search']);
    }
}
