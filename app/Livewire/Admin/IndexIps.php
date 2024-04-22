<?php

namespace App\Livewire\Admin;

use App\Models\Ban;
use App\Models\Ips;
use App\Models\User;
use Livewire\Component;
use Mchev\Banhammer\IP;

use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class IndexIps extends Component
{
    use WithPagination;
    public $search = '';
    protected $paginationTheme = 'bootstrap';
    public $sortDirection = 'desc';
    public $sortField = 'id';
    protected $listeners = [
        'deleteIP' => 'delete',
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function render()
    {

        $lock = IP::banned()->get();



        $ips = Ips::query()
            ->with(['user'])
            ->when($this->search, function ($query) {
                $query->where('ip', 'like', '%' . trim($this->search) . '%');
            })
            ->orWhereHas('user', function ($query) {
                $query->where('email', 'like', '%' . trim($this->search) . '%')
                    ->orWhere('id', 'like', '%' . trim($this->search) . '%')
                    ->orWhere('facebook', 'like', '%' . trim($this->search) . '%')
                    ->orWhere('whatsapp', 'like', '%' . trim($this->search) . '%');
            })

            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(100);


        return view('livewire.admin.index-ips', compact('ips', 'lock'));
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

    public function bannedIP($ip)
    {

        try {
            IP::ban($ip);
            $this->dispatch('success-auto-close', message: 'La IP ha sido bloqueada con éxito');
        } catch (\Throwable $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
    }

    public function UnBannedIP($ip)
    {

        try {
            IP::unban($ip);
            $this->dispatch('success-auto-close', message: 'La IP ha sido desbloqueada con éxito');
        } catch (QueryException $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {

            Ips::destroy($id);
            $this->dispatch(
                'success-auto-close',
                title: 'Eliminado!',
                message: 'La IP ha sido eliminada correctamente.'
            );
        } catch (QueryException $e) {
            $this->dispatch('error', message: 'Error al eliminar la IP - ' . $e->getMessage());
        }
    }
}
