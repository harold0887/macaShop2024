<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">menu_book</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0">
                                <h4 class="card-title font-weight-bold">Productos ({{$products->total()}} registros).</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body row ">
                        <div class="col-12">
                            <div class="row justify-content-between">
                                <div class="col-12 col-md-8   align-self-md-center">
                                    <div class="search-panels">
                                        <div class="search-group">
                                            <input required="" type="text" name="text" autocomplete="on" class="input" wire:model.live.debounce.500ms='search'>
                                            <label class="enter-label">Buscar por titulo o id</label>
                                            <div class="btn-box">

                                            </div>
                                            <div class="btn-box-x">
                                                <button class="btn-cleare" wire:click="clearSearch()">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                                                        <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" id="cleare-line"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-auto  align-self-md-center">
                                    <a class="btn btn-primary btn-block" href="{{ route('products.create') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="material-icons mr-2">add_circle</i>
                                            <span>Nuevo producto</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            @if ($search != '')
                            <small class="text-primary">{{ $products->count() }} resultados obtenidos</small>

                            @endif
                        </div>
                        @if (isset($products) && $products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="cursor:pointer" wire:click="setSort('id')">
                                            @if($sortField=='id')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Id
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('title')">
                                            @if($sortField=='title')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Nombre
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('price')">
                                            @if($sortField=='price')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Sin descuento
                                        </th>

                                        <th style="cursor:pointer" wire:click="setSort('price_with_discount')">
                                            @if($sortField=='price_with_discount')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Con descuento
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('folio')">
                                            @if($sortField=='folio')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Folio
                                        </th>
                                        <th>Categoría</th>
                                        <th style="cursor:pointer" wire:click="setSort('sales_count')">
                                            @if($sortField=='sales_count')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Ventas
                                        </th>
                                        <th>Grado</b></th>
                                        <th>Membresía</b></th>
                                        <th style="cursor:pointer" wire:click="setSort('status')">
                                            @if($sortField=='status')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            En tienda
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('descargas_count')">
                                            @if($sortField=='descargas_count')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Descargas
                                        </th>
                                        <th>Acciones</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr class="{{ $product->percentage > 0 ? 'text-danger' : '' }} {{ Storage::exists($product->document) ? '' : 'table-danger' }} {{ Storage::exists($product->itemMain) ? '' : 'table-danger' }}  ">
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->price }}</td>

                                        <td>{{ $product->price_with_discount }}</td>
                                        <td>
                                            <div class="togglebutton" wire:change="changeFolio({{ $product->id }}, '{{ $product->folio }}')">
                                                <label>
                                                    <input type="checkbox" {{ $product->folio == 1 ? 'checked ' : '' }}>
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>

                                            @foreach($product->categorias as $categoria)
                                            <span class="badge badge-info d-block my-1">
                                                {{ $categoria->name }}
                                            </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $product->sales_count }}

                                        </td>
                                        <td>{{ $product->grado->name }}</td>
                                        <td>
                                            @foreach($product->membresias as $membresia)
                                            <span class="badge badge-info d-block my-1">
                                                {{ $membresia->title }}

                                            </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="togglebutton" wire:change="changeStatus({{ $product->id }}, '{{ $product->status }}')">
                                                <label>
                                                    <input type="checkbox" {{ $product->status == 1 ? 'checked ' : '' }}>
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ $product->descargas_count }}</td>
                                        <td class="td-actions">
                                            <div class="btn-group m-0 d-flex" style="box-shadow: none !important">
                                                <button class="btn btn-warning btn-link" wire:click="downloadOriginalDocument({{ $product->id }})">
                                                    <i class="material-icons">download</i>
                                                </button>
                                                <a class="btn  btn-link" href="{{ route('products.show', $product->id) }}" target="_blank">
                                                    <i class="material-icons text-info">visibility</i>
                                                </a>
                                                <a class="btn  btn-link " href="{{ route('products.edit', $product->id) }}" target="_blank">
                                                    <i class="material-icons text-success">edit</i>
                                                </a>
                                                <button class="btn btn-success btn-link text-danger " onclick="confirmDelete('{{ $product->id }}', '{{ $product->title }}')">
                                                    <i class="material-icons text-danger">close</i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            {{ $products->links() }}
                        </div>
                        @else
                        <div class="col-12">
                            <p class="alert alert-warning">⚠️ ¡Ooooups! No se encontraron resultados.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //Confirmar eliminar producto
    function confirmDelete($id, $name) {
        swal({
            title: "¿Realmente quiere eliminar el producto: " + $name + "  ? ",
            type: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!",
        }).then((result) => {
            if (result.value) {
                Livewire.dispatch('delete-product', {
                    id: $id
                });
            } else {
                Swal('Cancelado', 'Tu archivo está seguro :)');
            }
        });
    }
</script>