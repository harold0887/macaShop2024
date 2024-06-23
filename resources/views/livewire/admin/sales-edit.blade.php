<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">receipt</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0 d-flex align-items-center">
                                <h4 class="card-title font-weight-bold">Editar orden {{ $order->id }}</h4>
                                <a class="btn btn-info btn-link" href="{{ route('sales.show', $order->id) }}">
                                    <i class=" material-icons">visibility</i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">

                        <div class="row  py-4 ">
                            <div class="col-12 col-lg-10">
                                <div class="row">
                                    <div class="form-group col-12 col-lg-3 ">
                                        <label class="bmd-label-floating">WhatsApp</label>
                                        <input type="text" class="form-control" wire:model.defer="contacto">
                                        @error('contacto')
                                        <small class=" text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12 col-lg-3 ">
                                        <label class="bmd-label-floating">Facebook</label>
                                        <input type="text" class="form-control" wire:model.defer="facebook">
                                        @error('facebook')
                                        <small class=" text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12 col-lg-3 ">
                                        <label class="bmd-label-floating">Id Mercado Pago</label>
                                        <input type="text" class="form-control" wire:model.defer="mercadoPago">
                                    </div>
                                    <div class="input-group col-12 col-lg-3">
                                        <label class="bmd-label-floating">Status</label>
                                        <select class="form-control" name="fop" wire:model.defer="status">
                                            <option value="">Selecciona un estatus...</option>
                                            <option value="create">pendiente de pago</option>
                                            <option value="approved">approved</option>
                                            <option value="pending">pending</option>
                                            <option value="in_process">in_process</option>
                                            <option value="rejected">rejected</option>
                                            <option value="cancelled">cancelled</option>
                                            <option value="refunded">refund</option>
                                            <option value="charged_back">charged_back</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group col-12 col-md-3">
                                        <label class="bmd-label-floating">Total de la compra</label>
                                        <input type="number" class="form-control" wire:model.defer="priceOrder">
                                    </div>
                                    <div class="form-group col-12 col-md-3">
                                        <label class="bmd-label-floating">Fecha de compra</label>
                                        <input type="date" class="form-control" wire:model.defer="dateOrder">
                                    </div>
                                    <div class="form-group col-12 col-md-3">
                                        <label class="bmd-label-floating">Link de Pago</label>
                                        <input type="text" class="form-control" wire:model.defer="link">
                                    </div>

                                    <div class="form-group col-12 col-md-3">
                                        <label class="bmd-label-floating">Comentarios</label>
                                        <input type="text" class="form-control" wire:model.defer="comentario">
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 col-lg-2">
                                <div class="row d-flex">
                                    <div class="col-6 col-lg-12 pt-2 py-lg-2 d-flex justify-content-center align-item-center ">
                                        <div class="togglebutton my-0">
                                            <label>
                                                <span class="text-muted">Active:
                                                    <input type="checkbox" wire:change="activeOrder()" {{ $order->active == 1 ? 'checked ' : '' }}>
                                                    <span class="toggle"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-12 py-0 pt-lg-3 d-flex justify-content-center align-item-center ">
                                        <button class="btn btn-info btn-link text-success my-0" wire:click='save'>
                                            <i class=" material-icons ">save</i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12 col-md-6 rounded  pl-4 border">
                                <h2 class="title text-center  text-sm sm:text-2x1 md:text-2xl  lg:text-2xl">
                                    Agregar membresías a la orden
                                </h2>
                                @foreach($memberships as $membership)
                                <div class="row pt-2">
                                    <div class="col-6 col-lg-8 align-self-center">
                                        @role('admin')
                                        <a class="btn btn-success btn-link p-0 m-0" href="{{ route('memberships.edit', $membership->id) }}" target="_blank">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        @endrole
                                        {{ $membership->title }} - ${{ $membership->price_with_discount }}

                                    </div>
                                    <div class="col-6 col-lg-4">

                                        @php
                                        $exist= false;
                                        @endphp
                                        @foreach($MembershipsIcluded as $item)
                                        @if($item->id == $membership->id )
                                        @php
                                        $exist= true;
                                        @endphp
                                        @endif
                                        @endforeach
                                        @if($exist)
                                        <button type="submit" class="btn p-1  btn-danger p-0" wire:click="removeMembership('{{ $membership->id }}')">
                                            <i class="material-icons">close</i>
                                            Eliminar
                                        </button>
                                        @else
                                        <button class="btn p-1  btn-success p-0" wire:click="addMembership('{{ $membership->id }}')">
                                            <i class="material-icons">add</i>
                                            Agergar
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                <div class="row pt-2">
                                    <div class="col-6 col-lg-8 align-self-center">
                                        {{ $registroAsistenciaPro->title }}
                                    </div>
                                    <div class="col-6 col-lg-4">

                                        @php
                                        $exist= false;
                                        @endphp
                                        @foreach($MembershipsIcluded as $item)
                                        @if($item->id == $registroAsistenciaPro->id )
                                        @php
                                        $exist= true;
                                        @endphp
                                        @endif
                                        @endforeach
                                        @if($exist)
                                        <button type="submit" class="btn p-1  btn-danger p-0" wire:click="removeMembership('{{ $registroAsistenciaPro->id }}')">
                                            <i class="material-icons">close</i>
                                            Eliminar
                                        </button>
                                        @else
                                        <button class="btn p-1  btn-success p-0" wire:click="addMembership('{{ $registroAsistenciaPro->id }}')">
                                            <i class="material-icons">add</i>
                                            Agergar
                                        </button>
                                        @endif
                                    </div>
                                </div>

                                <h2 class="title text-center  text-sm sm:text-2x1 md:text-2xl  lg:text-2xl border-top">
                                    Agregar paquetes a la orden
                                </h2>
                                @foreach($packages as $package)
                                <div class="row pt-2">
                                    <div class="col-6 col-lg-8 align-self-center">
                                        {{ $package->title }}
                                    </div>
                                    <div class="col-6 col-lg-4">
                                        @php
                                        $exist= false;
                                        @endphp
                                        @foreach($PackagesIcluded as $item)
                                        @if($item->id == $package->id )
                                        @php
                                        $exist= true;
                                        @endphp
                                        @endif
                                        @endforeach
                                        @if($exist)
                                        <button type="submit" class="btn p-1  btn-danger p-0" wire:click="removePackage('{{ $package->id }}')">
                                            <i class="material-icons">close</i>
                                            Eliminar
                                        </button>
                                        @else
                                        <button class="btn p-1  btn-success p-0" wire:click="addPackage('{{ $package->id }}')">
                                            <i class="material-icons">add</i>
                                            Agergar
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="title text-center  text-sm sm:text-2x1 md:text-2xl  lg:text-2xl border-top">
                                            Agregar documentos a la orden
                                        </h2>
                                    </div>
                                    <div class="col-12">
                                        <input type="search" class="form-control px-3 w-full" placeholder="Buscar título..." wire:model.live.debounce.500ms='search' style="border-radius: 30px !important">
                                    </div>
                                    <div class="col-4 text-end">
                                        @if ($search != '')
                                        <div class="d-flex mt-2">
                                            <span class="text-base">Borrar filtros </span>
                                            <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="clearSearch()">close</i>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @foreach($products as $products)
                                <div class="row pt-2">
                                    <div class="col-6 col-lg-8 align-self-center {{$products->status==0 ? 'text-danger':''}}">
                                        {{ $products->title }}
                                    </div>
                                    <div class="col-6 col-lg-4">

                                        @php
                                        $exist= false;
                                        @endphp
                                        @foreach($productsIncluded as $item)
                                        @if($item->id == $products->id )
                                        @php
                                        $exist= true;
                                        @endphp
                                        @endif
                                        @endforeach


                                        @if($exist)
                                        <button type="submit" class="btn p-1  btn-danger p-0" wire:click="removeProduct('{{ $products->id }}')">
                                            <i class="material-icons">close</i>
                                            Eliminar
                                        </button>
                                        @else
                                        <button class="btn p-1  btn-success p-0" wire:click="addProduct('{{ $products->id }}')">
                                            <i class="material-icons">add</i>
                                            Agergar
                                        </button>
                                        @endif








                                    </div>

                                </div>
                                @endforeach

                            </div>
                            <div class="col-md-6  rounded border">
                                <h2 class="title text-center  text-sm sm:text-2x1 md:text-2xl  lg:text-2xl">
                                    Membresías incluidas
                                </h2>
                                @foreach($MembershipsIcluded as $item)
                                <div class="row pt-2">
                                    <div class="col-md-2 my-1">
                                        <img src="{{ Storage::url($item->itemMain) }} " class="img-thumbnail">
                                    </div>
                                    <div class="col-12 col-md-9 align-self-center">
                                        {{ $item->title }} - ${{ $item->price }}
                                    </div>

                                </div>
                                @endforeach
                                <h2 class="title text-center  text-sm sm:text-2x1 md:text-2xl  lg:text-2xl border-top">
                                    Paquetes incluidos
                                </h2>

                                @foreach($PackagesIcluded as $item)
                                <div class="row pt-2">
                                    <div class="col-md-2 my-1">
                                        <img src="{{ Storage::url($item->itemMain) }} " class="img-thumbnail">
                                    </div>
                                    <div class="col-12 col-md-9 align-self-center">
                                        {{ $item->title }}
                                    </div>

                                </div>
                                @endforeach

                                <h2 class="title text-center  text-sm sm:text-2x1 md:text-2xl  lg:text-2xl border-top">
                                    Productos incluidos
                                </h2>

                                @foreach($productsIncluded as $item)
                                <div class="row pt-2">
                                    <div class="col-md-2 my-1">
                                        <img src="{{ Storage::url($item->itemMain) }} " class="img-thumbnail">
                                    </div>
                                    <div class="col-12 col-md-9 align-self-center">
                                        {{ $item->title }}
                                    </div>

                                </div>
                                @endforeach



                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>