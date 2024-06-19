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
    public $search = '';
    public $order;

    protected $paginationTheme = 'bootstrap';

    public $sortDirection = 'desc';
    public $sortField = 'id';
    public $link = '';
    public $idSelect = 'ssss';
    public function updatingSearch()
    {
        $this->resetPage();
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
                    ->orWhere('facebook', 'like', '%' . $this->search . '%')
                    ->orWhere('whatsapp', 'like', '%' . $this->search . '%')
                    ->orWhere('comment', 'like', '%' . trim($this->search) . '%');
            })

            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);


        return view('livewire.admin.index-sales', compact('orders'));
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





    // public function resendOrder($order)
    // {
    //     $materialesComprados = false;
    //     $MembresiasCompradas = [];

    //     $this->order = Order::findOrFail($order);




    //     $productosOrder = Order_Details::where('order_id', $this->order->id)->get();
    //     $customer = User::findOrFail($this->order->customer_id);






    //     foreach ($productosOrder as $item) {
    //         if ($item->membership_id != null) {


    //             $membresia = Membership::findOrFail($item->membership_id);

    //             $MembresiasCompradas[] = [
    //                 'membership_id' => $membresia->id,
    //                 'title' => $membresia->title,
    //                 'price' => $item->price,
    //             ];
    //         } elseif ($item->package_id != null || $item->product_id != null) {

    //             $materialesComprados = true;
    //         }
    //     }



    //     //enviar correo de materiales
    //     if ($materialesComprados) {
    //         $correo = new PaymentApprovedEmail($this->order->id, $customer->name,  $this->order->amount);
    //         Mail::to($customer->email)
    //             ->send($correo);

    //         $correoCopia = new PaymentApprovedEmail($this->order->id, $customer->name, $this->order->amount);
    //         Mail::to('arnulfoacosta0887@gmail.com')
    //             ->send($correoCopia);
    //         $this->emit('success-auto-close', [
    //             'message' => 'Orden enviada',
    //         ]);
    //     }

    //     //enviar correo de membresias
    //     foreach ($MembresiasCompradas as $membresia) {

    //         //validar si es membresia preescolar, se tiene que cambiar cada año
    //         if ($membresia['membership_id'] == 2006) {

    //             $correo = new MembresiaPreescolar($this->order->id, $customer->name, $customer->email, $membresia['price']);
    //             Mail::to($customer->email)
    //                 ->send($correo);
    //             $correoCopia = new MembresiaPreescolar($this->order->id, $customer->name, $customer->email, $membresia['price']);
    //             Mail::to('arnulfoacosta0887@gmail.com')
    //                 ->send($correoCopia);
    //             $this->emit('success-auto-close', [
    //                 'message' => 'Preescolar enviada',
    //             ]);
    //         }

    //         if ($membresia['membership_id'] == 2007) {
    //             $correo = new MembresiaPrimaria($this->order->id, $customer->name, $customer->email, $membresia['price']);
    //             Mail::to($customer->email)
    //                 ->send($correo);
    //             $correoCopia = new MembresiaPrimaria($this->order->id, $customer->name, $customer->email, $membresia['price']);
    //             Mail::to('arnulfoacosta0887@gmail.com')
    //                 ->send($correoCopia);
    //             $this->emit('success-auto-close', [
    //                 'message' => 'Primaria enviada',
    //             ]);
    //         }
    //     }
    // }
    //actualizar orden desde mercado pago, se actualiza desde hobs
    // public function updateStatus($id)
    // {
    //     $response = Http::get("https://api.mercadopago.com/v1/payments/$id" . "?access_token=APP_USR-2311547743825741-013023-3721797a3fbdf97bf2d4ff3f58000481-269113557");

    //     $response = json_decode($response);
    //     $newStatus = $response->status;
    //     try {
    //         Order::where('payment_id', $id)
    //             ->firstOrFail()
    //             ->update([
    //                 'status' => $newStatus,
    //             ]);

    //         $this->emit('success-auto-close', [
    //             'message' => 'El pago se actualizó con éxito',
    //         ]);
    //     } catch (QueryException $e) {
    //         $this->emit('error', [
    //             'error' => 'Ocurrio un error al actualizar el pago.',
    //         ]);
    //     }
    // }
}
