<?php

namespace App\Livewire\Admin;

use App\Models\Banner;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;

class IndexBanners extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    protected $listeners = [
        'delete-banner' => 'delete',
    ];



    public function render()
    {
        $banners = Banner::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('information', 'like', '%' . $this->search . '%');
        })->orderBy($this->sortField, $this->sortDirection)->paginate(5);
        return view('livewire.admin.index-banners', compact('banners'));
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
        try {
            Banner::findOrFail($id)->update([
                'status' => $status == 0 ? true : false
            ]);
            $this->dispatch('success-auto-close', message: "El cambio se realizo con éxito");
        } catch (QueryException $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {

            $banner = Banner::findOrFail($id);

            Banner::destroy($banner->id);
            if ($banner->desktop) {
                File::delete(storage_path("/app/public/{$banner->desktop}"));
            }

            if ($banner->mobile) {
                File::delete(storage_path("/app/public/{$banner->mobile}"));
            }





            $this->dispatch(
                'success',
                title: 'Eliminado!',
                message: 'El banner ha sido eliminado correctamente.',
            );
        } catch (QueryException $e) {

            $this->dispatch('error', message: 'Error al eliminar el registro - ' . $e->getMessage());
        }
    }
}
