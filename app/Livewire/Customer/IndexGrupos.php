<?php

namespace App\Livewire\Customer;

use App\Models\Grupo;
use Livewire\Component;
use App\Models\Membership;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class IndexGrupos extends Component
{
    public $sortDirection = 'desc';
    public $sortField = 'created_at';

    public function render()
    {
        $myGroups = Grupo::where('user_id', Auth::user()->id)
            ->where('oculto', false)
            ->get();
        $myGroupsHide = Grupo::where('user_id', Auth::user()->id)
            ->where('oculto', true)
            ->get();
        return view('livewire.customer.index-grupos', compact('myGroups', 'myGroupsHide'));
    }

    public function ocultar($id)
    {
        $group = Grupo::findOrFail($id);
        try {
            if ($group->user_id == Auth::user()->id) {
                $group->update([
                    'oculto' => true
                ]);
                $this->dispatch('success-auto-close', message: "El grupo se oculto con éxito");
            } else {
                $this->dispatch('error', message: "No cuenta con permisos para modificar el grupo: " . $group->id);
            }
        } catch (\Throwable $e) {
            $this->dispatch('error', message: "Error al ocultar el grupo " . $e->getMessage());
        }
    }
    public function mostrar($id)
    {
        $group = Grupo::findOrFail($id);
        try {
            if ($group->user_id == Auth::user()->id) {
                $group->update([
                    'oculto' => false
                ]);
                $this->dispatch('success-auto-close', message: "El grupo se mostro con éxito");
            } else {
                $this->dispatch('error', message: "No cuenta con permisos para modificar el grupo: " . $group->id);
            }
        } catch (\Throwable $e) {
            $this->dispatch('error', message: "Error al mostrar el grupo " . $e->getMessage());
        }
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

    #[On('delete-group')]
    public function delete($id)
    {
        $group = Grupo::findOrFail($id);
        try {


            if ($group->user_id == Auth::user()->id) {
                $group->update([
                    'user_id' => 2
                ]);
                $this->dispatch('success-auto-close', message: 'El grupo se ha eliminado con éxito');
            } else {
                $this->dispatch('error', message: "No cuenta con permisos para modificar el grupo: " . $group->id);
            }
        } catch (\Throwable $e) {
            $this->dispatch('error', message: "Error al eliminar el grupo " . $e->getMessage());
        }
    }
    public function upgrade()
    {


        $this->dispatch('infoPro', message: "La versión gratuita permite registrar solo un grupo, si necesita registrar más grupos. Adquiera la versión PRO");
    }
}
