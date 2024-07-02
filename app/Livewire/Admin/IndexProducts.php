<?php

namespace App\Livewire\Admin;

use Throwable;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class IndexProducts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $sortDirection = 'desc';
    public $sortField = 'created_at';
    protected $listeners = [
        'delete-product' => 'delete',
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%');
        })->withCount(['sales as salesWeb' => function ($query) {
            $query->whereHas('order', function ($query) {
                $query
                    ->where('status', 'approved')
                    ->where('payment_type', '!=', 'externo')
                    ->whereNotIn('customer_id', [1, 5, 8218]);
            });
        }])
            ->withCount(['sales as salesexternal' => function ($query) {
                $query->whereHas('order', function ($query) {
                    $query
                        ->where('status', 'approved')
                        ->where('payment_type', 'externo')
                        ->whereNotIn('customer_id', [1, 5, 8218]);
                });
            }])
            ->withCount('descargas')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(50);



        return view('livewire.admin.index-products', compact('products'));
    }

    public function delete($id)
    {
        try {

            $product = Product::findOrFail($id);
            $items = $product->items;
            Product::destroy($product->id);
            if ($product->itemMain) {
                File::delete(storage_path("/app/public/{$product->itemMain}"));
            }

            if ($product->document) {
                File::delete(storage_path("/app/public/{$product->document}"));
            }

            if ($product->video) {
                File::delete(storage_path("/app/public/{$product->video}"));
            }


            foreach ($items as $item) {
                if ($item->photo) {
                    File::delete(storage_path("/app/public/{$item->photo}"));
                }
            }

            $this->dispatch(
                'success',
                title: 'Eliminado!',
                message: 'El archivo ha sido eliminado correctamente.',
            );
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $messageError = 'El producto tiene relacion con otros registros.';
            } else {
                $messageError = $e->getMessage();
            }
            $this->dispatch('error', message: 'Error al eliminar el registro - ' . $messageError);
        }
    }
    public function changeStatus($id, $status)
    {
        try {
            Product::findOrFail($id)->update([
                'status' => $status == 0 ? true : false
            ]);
            $this->dispatch('success-auto-close', message: "El cambio se realizo con éxito");
        } catch (QueryException $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
    }
    public function changeEnvio($id, $envio)
    {
        try {
            Product::findOrFail($id)->update([
                'envio' => $envio == 0 ? true : false
            ]);
            $this->dispatch('success-auto-close', message: "El cambio se realizo con éxito");
        } catch (QueryException $e) {
            $this->dispatch('error', message: $e->getMessage());
        }
    }

    public function changeFolio($id, $status)
    {
        try {
            Product::findOrFail($id)->update([
                'folio' => $status == 0 ? true : false
            ]);
            $this->dispatch('success-auto-close', message: "El cambio se realizo con éxito");
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

    public function downloadOriginalDocument($id)
    {
        try {
            $document = Product::findOrFail($id);
            return Storage::download($document->document, $document->title);
        } catch (Throwable $th) {
            $this->dispatch('error', message: 'Error al descargar el documento - ' . $th->getMessage());
        }
    }
}
