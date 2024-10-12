<?php

namespace App\Livewire\Admin;

use App\Models\Ban;
use App\Models\Ips;
use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use Mchev\Banhammer\IP;
use Livewire\Attributes\On;
use Illuminate\Database\QueryException;

class ShowUser extends Component
{
    public $user;

    public $ipSelect = '';
    public $usersIPSelect;
    public $sortDirection = 'desc';
    public $sortField = 'id';
    protected $listeners = ['some-event-users-ips' => '$refresh'];

    public function mount($id)
    {
        $this->user =  User::findOrFail($id);
    }
    public function render()
    {
        $lock = IP::banned()->get();


        return view('livewire.admin.show-user', compact('lock'))
            ->extends('layouts.app', [
                'title' => 'Usuarios',
                'navbarClass' => 'navbar-transparent',
                'activePage' => 'users',
            ])
            ->section('content');
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
        } finally {
            $this->dispatch('some-event-users-ips');
        }
    }

    #[On('verificar-email')]
    public function verificarEmail($id)
    {
        $user = User::findOrFail($id);
        try {
            $user->update([
                'email_verified_at' => now(),
                'comment' => 'Email verificado por un administrador.'
            ]);
            $this->dispatch('success-auto-close', message: 'El correo ha sido verificado con éxito');
            $this->dispatch('reload');
        } catch (\Throwable $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
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

    public function showRelated($ip)
    {
        $this->ipSelect = $ip;

        $this->usersIPSelect = Ips::where('ip', $this->ipSelect)->get();
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

    public function changeStatusUser($id, $status)
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
        } finally {
            $this->dispatch('some-event-users-ips');
        }
    }
}
