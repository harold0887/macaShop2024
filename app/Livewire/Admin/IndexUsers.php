<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use Mchev\Banhammer\IP;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class IndexUsers extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';
    public $sortDirection = 'desc';
    public $sortField = 'id';
    protected $listeners = [
        'deleteUser' => 'delete',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $users = User::where('name', 'like', '%' . trim($this->search) . '%')
            ->orwhere('email', 'like', '%' . trim($this->search) . '%')
            ->orwhere('id', 'like', '%' . trim($this->search) . '%')
            ->orwhere('facebook', 'like', '%' . $this->search . '%')
            ->orwhere('whatsapp', 'like', '%' . $this->search . '%')
            ->withCount('sales')
            ->withCount('ips')
            ->withCount('roles')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(50);
        return view('livewire.admin.index-users', compact('users'));
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

    public function changeStatus($id, $status)
    {

        $user = User::findOrFail($id);

        try {


            if ($user->hasRole('admin')) {
                $this->dispatch('error', message: 'No puede cambiar el status a un administrador');
            } else {
                if ($status == 1) {
                    $user->ban();
                    $user->update([
                        'status' => 0,
                    ]);

                    foreach ($user->ips as $ip) {
                        IP::ban($ip->ip);
                    }


                    $this->dispatch('success-auto-close', message: 'El usuario ha sido bloqueado con éxito');
                } else {
                    $user->unban();
                    $user->update([
                        'status' => 1,
                    ]);
                    foreach ($user->ips as $ip) {
                        IP::unban($ip->ip);
                    }

                    $this->dispatch('success-auto-close', message: 'El usuario ha sido desbloqueado con éxito');
                }
            }
        } catch (\Throwable $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
    }

    public function newSales(User $user)
    {

        //obtener la ultima compra

        $lastOrder = Order::latest()->first();


        try {

            $newOrder = Order::create([
                'customer_id' => $user->id,
                'amount' => 350,
                'status' => 'approved',
                'payment_type' => 'Externo',
                'payment_id' => $lastOrder->payment_id + 1,
                'order_id' => $lastOrder->payment_id + 1,
                'active' => false,
            ]);


            return redirect()->to('dashboard/sales/' . $newOrder->id . '/edit')->with('success-auto-close', 'Registro exitoso');

            //return back()->with('success', 'Registro exitoso');
        } catch (\Throwable $e) {
            return back()->with('error', 'Error al guardar el registro - ' .  $e->getMessage());
        }
    }
    public function delete($id)
    {
        //dd($user);
        try {

            User::destroy($id);
            $this->dispatch(
                'success-auto-close',
                title: 'Eliminado!',
                message: 'El usuario ha sido eliminado correctamente.'

            );
        } catch (\Throwable $e) {
            if ($e->getCode() == 23000) {
                $messageError = 'El usuario tiene relacion con otros registros.';
            } else {
                $messageError = $e->getMessage();
            }
            $this->dispatch('error', message: 'Error al eliminar el usuario - ' . $messageError);
        }
    }
}
