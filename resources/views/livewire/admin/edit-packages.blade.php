<div class="row ">

    <div class="col-12 col-lg-6 shadow rounded">
        <h4 class="title  text-center text-muted">{{$package->products->count()}}  documentos incluidos en el paquete </h4>
        @foreach($package->products as $item)
        <div class="row justify-content-center">
            <div class="col-7 col-md-3">
                <img src="{{ Storage::url($item->itemMain) }} " class="img-thumbnail">
            </div>
            <div class="col-12 col-md-9 align-self-center text-center text-lg-left">
                <p>
                    <b class="text-sm sm:text-1x1  ">{{ $item->title }}</b>
                    <br>
                </p>
            </div>

        </div>
        @endforeach



    </div>
    <div class="col-12 col-lg-6 shadow rounded">
        <div class="row ">
            <div class="col-12">
                <h4 class="title  text-center text-muted">Agregar documentos al paquete</h4>
            </div>
            <div class="col-8">
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

            <div class="col-12 col-lg-8 align-self-center text-center text-lg-left">
                <p>
                    <b class="text-sm sm:text-1x1 {{$products->status==0? 'text-danger':''}}">{{ $products->title }}</b>
                    <br>
                </p>
            </div>
            <div class="col-6 col-lg-2 text-center ">
                <button class="btn p-1  btn-success p-0" wire:click="addToPackage('{{ $products->id }}')">
                    <i class="material-icons">add</i>
                    Agergar
                </button>
            </div>
            <div class="col-6 col-lg-2 text-center ">
                @foreach($package->products as $item)

                @if($item->id == $products->id )
                <button type="submit" class="btn p-1  btn-danger p-0" wire:click="removeToPackage('{{ $products->id }}')">
                    <i class="material-icons">close</i>
                    Quitar
                </button>

                @endif

                @endforeach
            </div>
        </div>

        @endforeach

    </div>
</div>