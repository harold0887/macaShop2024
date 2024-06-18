<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class DashboardRender extends Component
{
    use WithPagination;
    public $search = '';
    public $day;
    public  $salesDay, $salesMonth, $salesYear;
    public $sortDirection = 'desc', $sortField = 'created_at';
    public $monthSelect, $monthSelectName, $yearSelect;
    public  $productsDay, $packagesDay, $membershipsDay;
    public  $topProducts;
    public $salesRange;
    public $start, $end;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['setRange'];
    public function mount()

    {
        $day = now()->format('Y-m-d');
        $this->day = now()->format('Y-m-d');
        $this->monthSelect = now()->format('m');
        $this->yearSelect = now()->format('Y');
        $this->setNames();
    }


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

        //dd( $this->orders);

        $this->salesMonth = Order::whereMonth('created_at', $this->monthSelect)
            ->whereYear('created_at', $this->yearSelect)
            ->where('status', 'approved')
            //->where('payment_type', '!=', 'externo')
            ->sum('amount');

        $this->salesYear = Order::whereYear('created_at', $this->yearSelect)
            ->where('status', 'approved')
            //->where('payment_type', '!=', 'externo')
            ->sum('amount');


        //Obtener todas las ventas del día (productos, paquetes y membresías)
        $this->salesDay = Order::whereBetween('created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
            ->where('status', 'approved')
            //->where('payment_type', '!=', 'externo')
            ->sum('amount');

        //Obtener todas las ventas de productos del día con el numero de ventas y la suma de ventas de cada producto
        $this->productsDay = Product::whereHas('orders', function ($query) {
            $query->whereBetween('orders.created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                ->where('status', 'approved');
            //->where('payment_type', '!=', 'externo');
        })
            ->withCount(['sales' => function ($query) {
                $query->whereBetween('created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                    ->whereHas('order', function ($query) {
                        $query->whereBetween('orders.created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                            ->where('status', 'approved');
                        //->where('payment_type', '!=', 'externo');
                    });
            }])
            ->withSum(['sales' => function ($query) {
                $query->whereBetween('created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                    ->whereHas('order', function ($query) {
                        $query->whereBetween('orders.created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                            ->where('status', 'approved');
                        //->where('payment_type', '!=', 'externo');
                    });
            }], 'price')
            ->get();


        //Obtener todas las ventas de paquetes del día con el numero de ventas y la suma de ventas de cada producto
        $this->packagesDay = Package::whereHas('orders', function ($query) {
            $query->whereBetween('orders.created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                ->where('status', 'approved');
            //->where('payment_type', '!=', 'externo');
        })
            ->withCount(['sales' => function ($query) {
                $query->whereBetween('created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                    ->whereHas('order', function ($query) {
                        $query->whereBetween('orders.created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                            ->where('status', 'approved');
                        //->where('payment_type', '!=', 'externo');
                    });
            }])
            ->withSum(['sales' => function ($query) {
                $query->whereBetween('created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                    ->whereHas('order', function ($query) {
                        $query->whereBetween('orders.created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                            ->where('status', 'approved');
                        //->where('payment_type', '!=', 'externo');
                    });
            }], 'price')
            ->get();

        //Obtener todas las ventas de membresías del día con el numero de ventas y la suma de ventas de cada producto
        $this->membershipsDay = Membership::whereHas('orders', function ($query) {
            $query->whereBetween('orders.created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                ->where('status', 'approved');
            //->where('payment_type', '!=', 'externo');
        })
            ->withCount(['sales' => function ($query) {
                $query->whereBetween('created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                    ->whereHas('order', function ($query) {
                        $query->whereBetween('orders.created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                            ->where('status', 'approved');
                        //->where('payment_type', '!=', 'externo');
                    });
            }])
            ->withSum(['sales' => function ($query) {
                $query->whereBetween('created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                    ->whereHas('order', function ($query) {
                        $query->whereBetween('orders.created_at', [$this->day . " 00:00:00", $this->day . " 23:59:59"])
                            ->where('status', 'approved');
                        // ->where('payment_type', '!=', 'externo');
                    });
            }], 'price')
            ->get();


        $this->topProducts = Product::withCount(['sales' => function ($query) {
            $query->whereHas('order', function ($query) {
                $query
                    ->where('status', 'approved');
                //->where('payment_type', '!=', 'externo');
            });
        }])
            ->withSum(['sales' => function ($query) {
                $query->whereHas('order', function ($query) {
                    $query
                        ->where('status', 'approved');
                    //->where('payment_type', '!=', 'externo');
                });
            }], 'price')
            ->orderBy('sales_count', 'desc')
            ->take(10)
            ->get();


        return view('livewire.dashboard-render', compact('orders'));
    }

    public function setRange($start, $end)
    {

        $this->salesRange = Order::whereBetween('created_at', [Carbon::parse($start . " 00:00:01"), Carbon::parse($end . "23:59:59")])
            ->where('status', 'approved')
            //->where('payment_type', '!=', 'externo')
            ->sum('amount');
    }



    public function setNames()
    {
        switch ($this->monthSelect) {
            case 1:
                $this->monthSelectName = "enero";
                break;
            case 2:
                $this->monthSelectName = "febrero";
                break;
            case 3:
                $this->monthSelectName = "marzo";
                break;
            case 4:
                $this->monthSelectName = "abril";
                break;
            case 5:
                $this->monthSelectName = "mayo";
                break;
            case 6:
                $this->monthSelectName = "junio";
                break;
            case 7:
                $this->monthSelectName = "julio";
                break;
            case 8:
                $this->monthSelectName = "agosto";
                break;
            case 9:
                $this->monthSelectName = "septiembre";
                break;
            case 10:
                $this->monthSelectName = "octubre";
                break;
            case 11:
                $this->monthSelectName = "noviembre";
                break;
            case 12:
                $this->monthSelectName = "diciembre";
                break;
            default:

                break;
        }
    }

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
    public function clearMonth()
    {
        $this->monthSelect = now()->format('m');
        $this->setNames();
    }

    public function success1()
    {
        $this->dispatch(
            'success',
            title: 'Eliminado prueba!',
            message: 'El archivo ha sido eliminado correctamentesssssss.',
        );
    }

    public function successauto1()
    {
        $this->dispatch(
            'success-auto-close',
            title: 'Mensaje de prueba!',
            message: 'La orden se elimino de manera correcta pruebassssss'
        );
    }





    public function error1()
    {
        $this->dispatch('error', message: 'Error al eliminar el registro - error de prueba');
    }
    public function info1()
    {
        $this->dispatch('infoPro', message: 'La versión gratuita permite registrar máximo pruebasadadsd');
    }

    public function sendSuccessHtml()
    {
        $this->dispatch(
            'sendSuccessHtml',
            product: "pridcl priabas",
            note: 'Se han enviado correctamente a: ',
            email: "eruebasadssad@gmail.com"
        );
    }
}
