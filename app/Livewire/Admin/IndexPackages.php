<?php

namespace App\Livewire\Admin;

use App\Models\Package;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class IndexPackages extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';

    protected $listeners = [
        'delete-package' => 'delete',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {

        $packages = Package::where(function ($query) {
            $query->where('packages.title', 'like', '%' . $this->search . '%');
        })->withCount(['sales' => function ($query) {
            $query->whereHas('order', function ($query) {
                $query
                    ->where('status', 'approved')
                    ->where('payment_type', '!=', 'externo');
            });
        }])
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(50);
        return view('livewire.admin.index-packages', compact('packages'));
    }

    public function delete($id)
    {
        try {
            $object = Package::findOrFail($id);
            Package::destroy($id);
            if ($object->itemMain) {
                File::delete(storage_path("/app/public/{$object->itemMain}"));
            }
            $this->dispatch(
                'success',
                title: 'Eliminado!',
                message: 'El paquete ha sido eliminado correctamente.',
            );
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $messageError = 'El paquete tiene relacion con otros registros.';
            } else {
                $messageError = $e->getMessage();
            }
            $this->dispatch('error', message: 'Error al eliminar el registro - ' . $messageError);
        }
    }
    public function changeStatusPackage($id, $status)
    {
        try {
            Package::findOrFail($id)->update([
                'status' => $status == 0 ? true : false
            ]);
            $this->dispatch('success-auto-close', message: 'El cambio se realizo con éxito');
        } catch (QueryException $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
    }

    public function clearSearch()
    {
        $this->reset(['search']);
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
}
