<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Membership;
use Illuminate\Support\Facades\Request;

class EditMembership extends Component
{
    public $patch, $ids, $membership;
    protected $listeners = ['refresh-membership' => '$refresh'];

    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
        $this->membership = Membership::findOrFail($this->ids);
    }
    public function render()
    {
        $products = Product::where('status', true)
            ->orderBy('name', 'asc')->get();
        return view('livewire.edit-membership', compact('products'));
    }

    public function addToPackage($id)
    {
        try {
            $this->membership->products()->attach($id);
            $this->dispatch('refresh-membership');
            $this->dispatch('success-auto-close', message: 'Archivo agregado correctamente.');
        } catch (\Throwable $e) {
            $this->dispatch('error', message: 'Error al agregar el registro - ' . $e->getMessage());
        }
    }
    public function removeToPackage($id)
    {
        try {
            $this->membership->products()->detach($id);
            $this->dispatch('refresh-membership');
            $this->dispatch('success-auto-close', message: 'Archivo eliminado correctamente.');
        } catch (\Throwable $e) {
            $this->dispatch('error', message: 'Error al eliminar el archivo - ' . $e->getMessage());
        }
    }
}
