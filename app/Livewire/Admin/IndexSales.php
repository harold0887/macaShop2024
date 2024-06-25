<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use App\Models\Membership;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Mail\PaymentReminder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use MercadoPago\Resources\User\Sales;
use Illuminate\Database\QueryException;

class IndexSales extends Component
{
    use WithPagination;
    //public $search = '';
    public $order;

    protected $paginationTheme = 'bootstrap';

    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    public $link = '';
    public $filters = [
        'search' => '',
        'fromDate' => '',
        'toDate' => '',
        'status' => '',
        'origen' => ''
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $orders = Order::filter($this->filters)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);

        $ingresos = Order::filter($this->filters)
            ->where('status', 'approved')
            ->sum('amount');
        return view('livewire.admin.index-sales', compact('orders', 'ingresos'));
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
        $this->reset(['filters']);
    }


    #[On('delete-sales')]
    public function delete($id)
    {
        try {
            Order::destroy($id);

            $this->dispatch(
                'success-auto-close',
                title: 'Eliminado!',
                message: 'La orden se elimino de manera correcta'
            );
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $messageError = 'La orden tiene uno o más productos';
            } else {
                $messageError = $e->getMessage();
            }
            $this->dispatch('error', message: 'Error al eliminar el registro - ' . $messageError);
        }
    }

    #[On('send-reminder-cliete')]
    public function reminder($id)
    {
        try {

            $order = Order::findOrFail($id);
            if ($order->link != null) {
                $confirmacionOrder = new PaymentReminder($order);
                Mail::to($order->user->email) //enviar correo al cliente
                    ->send($confirmacionOrder);

                $order->update([
                    'payment_reminder' => $order->payment_reminder + 1,
                ]);

                $this->dispatch(
                    'success-auto-close',
                    title: 'Enviado!',
                    message: 'Se ha enviado la notificación de pago al cliente'
                );
            } else {
                $this->dispatch('error', message: 'La orden no cuenta con link de pago.');
            }
        } catch (QueryException $e) {

            $this->dispatch('error', message: 'Error al enviar la notificación de pago - ' . $e);
        }
    }
    #[On('send-reminder-prueba')]
    public function reminderPrueba($id)
    {
        try {

            $order = Order::findOrFail($id);
            if ($order->link != null) {
                $sendLinkPayment = new PaymentReminder($order);
                Mail::to("arnulfoacosta0887@gmail.com") //enviar correo de prueba
                    ->send($sendLinkPayment);

                $this->dispatch(
                    'success-auto-close',
                    title: 'Enviado!',
                    message: 'Se ha enviado la notificación de pago como prueba.'
                );
            } else {
                $this->dispatch('error', message: 'La orden no cuenta con link de pago.');
            }
        } catch (QueryException $e) {

            $this->dispatch('error', message: 'Error al enviar la notificación de pago - ' . $e);
        }
    }
}
