<?php

namespace App\Livewire\Admin;

use App\Models\Ban;
use App\Models\User;
use Livewire\Component;
use Mchev\Banhammer\IP;
use Livewire\Attributes\On;

class ShowUser extends Component
{
    public $user;

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
        }
    }

    #[On('verificar-email')]
    public function verificarEmail($id)
    {
        $user = User::findOrFail($id);
        try {
            $user->update([
                'email_verified_at' => now(),
                'comment'=>'Email verificado por un administrador.'
            ]);
            $this->dispatch('success-auto-close', message: 'El correo ha sido verificado con éxito');
            $this->dispatch('reload');
        } catch (\Throwable $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
    }
}
