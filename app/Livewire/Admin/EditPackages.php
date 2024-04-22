<?php

namespace App\Livewire\Admin;

use App\Models\Package;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Request;

class EditPackages extends Component
{
    public $patch, $ids, $package, $search = '';

    protected $listeners = ['some-event' => '$refresh'];

    public function mount()
    {
        $patch = Request::fullUrl();
        $this->patch = Request::fullUrl();
        $div = explode("/", $patch);
        $this->ids = $div[5];
        $this->package = Package::findOrFail($this->ids);
    }
    public function render()
    {
        $products = Product::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%');
        })
            ->orderBy('name', 'asc')->get();

        return view('livewire.admin.edit-packages', compact('products'));
    }

    public function addToPackage($id)
    {
        try {
            $this->package->products()->attach($id);
            $this->dispatch('some-event')->self();
            $this->dispatch('success-auto-close', message: 'Archivo agregado correctamente.');
        } catch (\Throwable $e) {
            $this->dispatch('error', message: 'Error al agregar el archivo - ' . $e->getMessage());
        }
    }
    public function removeToPackage($id)
    {
        try {
            $this->package->products()->detach($id);
            $this->dispatch('some-event')->self();
            $this->dispatch('success-auto-close', message: 'Archivo eliminado correctamente.');
        } catch (\Throwable $e) {
            $this->dispatch('error', message: 'Error al eliminar el archivo - ' . $e->getMessage());
        }
    }
    public function clearSearch()
    {
        $this->reset(['search']);
    }
}
