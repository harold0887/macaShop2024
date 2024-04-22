<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Membership;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Livewire\Attributes\On;

class IndexMemberships extends Component
{
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';


    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $memberships = Membership::orderBy($this->sortField, $this->sortDirection)
            ->where('title', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%')

            ->paginate(15);
        return view('livewire.admin.index-memberships', compact('memberships'));
    }

    #[On('delete-membership')]
    public function delete($id)
    {

        try {
            $object = Membership::findOrFail($id);
            Membership::destroy($id);
            if ($object->itemMain) {
                File::delete(storage_path("/app/public/{$object->itemMain}"));
            }

            $this->dispatch(
                'success-auto-close',
                title: 'Eliminado!',
                message: 'La membresía ha sido eliminado correctamente.'
            );
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $messageError = 'La membresía tiene relacion con otros registros.';
            } else {
                $messageError = $e->getMessage();
            }
            $this->dispatch('error', message: 'Error al eliminar el registro - ' .  $messageError);
        }
    }

    public function changeStatus($id, $status)
    {
        try {
            Membership::findOrFail($id)->update([
                'status' => $status == 0 ? true : false
            ]);
            $this->dispatch(
                'success-auto-close',
                message: 'El cambio se realizo con éxito',
            );
        } catch (QueryException $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
    }

    public function changeMain($id, $status)
    {
        $oferta = Membership::findOrFail($id);
        try {

            if ($oferta->price_with_discount >=  $oferta->price) {
                $this->dispatch('error', message: "Esta membresía no tiene descuento");
            } elseif ($oferta->status == '0') {
                $this->dispatch('error', message: "Esta membresía no esta activa");
            } else {
                $oferta->update([
                    'main' => $status == 0 ? true : false
                ]);

                $this->dispatch(
                    'success-auto-close',
                    message: 'El cambio se realizo con éxito',
                );
            }
        } catch (QueryException $e) {
            $this->dispatch('error', message: $e->getMessage());
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
    public function clearSearch()
    {
        $this->reset(['search']);
    }
}
