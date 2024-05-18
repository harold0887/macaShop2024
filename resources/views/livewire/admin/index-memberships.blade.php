<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">card_membership</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0">
                                <h4 class="card-title font-weight-bold">Membresías ({{$memberships->total()}} registros).</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12">
                            <div class="row justify-content-between">
                                <div class="col-12 col-md-8   align-self-md-center">
                                    <div class="search-panels">
                                        <div class="search-group">
                                            <input required="" type="text" name="text" autocomplete="on" class="input" wire:model.live.debounce.500ms='search'>
                                            <label class="enter-label">Buscar por nombre o id</label>
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
                                    <a class="btn btn-primary btn-block" href="{{ route('memberships.create') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="material-icons mr-1">add_circle</i>
                                            Nueva membresía
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>






                        <div class="col-12">
                            @if ($search != '')
                            <small class="text-primary">{{ $memberships->count() }} resultados obtenidos</small>

                            @endif
                        </div>
                        @if (isset($memberships) && $memberships->count() > 0)
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

                                            ID
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
                                            Precio sin descuento

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


                                            Precio con descuento
                                        </th>
                                        <th>Materiales</th>
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
                                        <th style="cursor:pointer" wire:click="setSort('start')">
                                            @if($sortField=='start')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Inicio
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('expiration')">
                                            @if($sortField=='expiration')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Fin
                                        </th>
                                        <th>Vigencia</th>
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
                                            Estatus
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('main')">
                                            @if($sortField=='main')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Ofreta
                                        </th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($memberships as $membership)
                                    <tr class="{{ $membership->expiration < now() ? 'table-danger' : '' }}">
                                        <td>{{ $membership->id }}</td>
                                        <td>{{ $membership->title }}</td>
                                        <td>{{ $membership->price }}</td>

                                        <td>{{ $membership->price_with_discount }}</td>
                                        <td>{{ $membership->products->count() }}</td>
                                        <td>
                                            <div class="row">
                                                <table>


                                                    <tr style="background-color: #11ffee00 !important;">
                                                        <td class="py-0 px-1">web</td>
                                                        <td class="py-0 px-1"> {{ $membership->salesWeb }}</td>

                                                    </tr>
                                                    <tr style="background-color: #11ffee00 !important; ">
                                                        <td class="py-0 px-1" style="border:none !important">Externo</td>
                                                        <td class="py-0 px-1" style="border:none !important">{{ $membership->salesexternal }}</td>
                                                    </tr>
                                                    <tr style="background-color: #11ffee00 !important; ">
                                                        <td class="py-0 px-1" style="border:none !important">Total</td>
                                                        <td class="py-0 px-1" style="border:none !important">{{ $membership->salesAll }}</td>
                                                    </tr>
                                                </table>
                                            </div>



                                        </td>
                                        <td>{{date_format(new DateTime($membership->start),'d-M-Y')}} </td>
                                        <td>{{date_format(new DateTime($membership->expiration),'d-M-Y')}} </td>
                                        <td>{{ $membership->vigencia }}</td>
                                        <td>
                                            <div class="togglebutton" wire:change="changeStatus({{ $membership->id }}, '{{ $membership->status }}')">
                                                <label>
                                                    <input type="checkbox" {{ $membership->status == 1 ? 'checked ' : '' }} name="status">
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="togglebutton" wire:change="changeMain({{ $membership->id }}, '{{ $membership->main }}')">
                                                <label>
                                                    <input type="checkbox" {{ $membership->main == 1 ? 'checked ' : '' }} name="status">
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="td-actions">
                                            <a class="btn  btn-link" href="{{ route('memberships.show', $membership->id) }}" target="_blank">
                                                <i class="material-icons text-info">visibility</i>
                                            </a>
                                            <a class="btn btn-success btn-link" href="{{ route('memberships.edit', $membership->id) }}">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="btn btn-success btn-link " onclick="confirmDelete('{{ $membership->id }}', '{{ $membership->title }}')">
                                                <i class="material-icons text-danger ">close</i>
                                            </button>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            {{ $memberships->links() }}
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
    //Confirmar eliminar la membresía
    function confirmDelete($id, $name) {
        swal({
            title: "¿Realmente quiere eliminar la membresía: " + $name + "  ? ",
            type: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!",
        }).then((result) => {
            if (result.value) {
                Livewire.dispatch('delete-membership', {
                    id: $id
                });
            } else {
                Swal('Cancelado', 'Tu archivo está seguro :)');
            }
        });
    }
</script>