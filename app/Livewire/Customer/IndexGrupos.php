<?php

namespace App\Livewire\Customer;

use App\Models\Grupo;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class IndexGrupos extends Component
{
    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    public function render()
    {
        $groupTest = Grupo::findOrFail(1);
        $myGroups = Grupo::where('user_id', Auth::user()->id)
            ->where('oculto', false)
            ->get();
        $myGroupsHide = Grupo::where('user_id', Auth::user()->id)
            ->where('oculto', true)
            ->get();

        return view('livewire.customer.index-grupos', compact('groupTest', 'myGroups', 'myGroupsHide'));
    }

    public function ocultar($id)
    {

        try {
            Grupo::findOrFail($id)->update([
                'oculto' => true
            ]);
            $this->dispatch('success-auto-close', message: "El grupo se oculto con éxito");
        } catch (\Throwable $e) {
            $this->dispatch('error', message: "Erro al ocultar el grupo " . $e->getMessage());
        }
    }
    public function mostrar($id)
    {

        try {
            Grupo::findOrFail($id)->update([
                'oculto' => false
            ]);
            $this->dispatch('success-auto-close', message: "El grupo se mostro con éxito");
        } catch (\Throwable $e) {
            $this->dispatch('error', message: "Error al mostro el grupo " . $e->getMessage());
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

        try {
            $group = Grupo::findOrFail($id);

            if ($group->user_id == Auth::user()->id) {
                Grupo::destroy($group->id);
                $this->dispatch('success-auto-close', message: 'El grupo se ha eliminado con éxito');
            } else {
                $this->dispatch('error', message: "No cuenta con permisos para eliminar este grupo.");
            }
        } catch (\Throwable $e) {
            $this->dispatch('error', message: "Error al eliminar el grupo " . $e->getMessage());
        }
    }
}
