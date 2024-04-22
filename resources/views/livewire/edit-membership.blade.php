<div class="row ">
    @include('includes.spinner-livewire')
    <div class="col-12 col-lg-6 shadow rounded">
        <h4 class="title  text-center text-muted">Documentos incluidos en la membresía</h4>
        @foreach($membership->products as $item)
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
        <h4 class="title  text-center text-muted">Agregar documentos a la membresía</h4>
        @foreach($products as $products)

        <div class="row pt-2 justify-content-center">

            <div class="col-12 col-lg-8 align-self-center  text-lg-left">
                <span>
                    {{ $products->title }}
                </span>
            </div>
            <div class="col-8 col-lg-2 text-center ">
                @php
                $exist= false;
                @endphp
                @foreach($membership->products as $item)
                @if($item->id == $products->id )
                @php
                $exist= true;
                @endphp
                @endif
                @endforeach


                @if($exist)
                <button class="btn p-1  btn-danger p-0 w-100" wire:click="removeToPackage('{{ $products->id }}')">
                    <i class="material-icons">close</i>
                    Quitar
                </button>
                @else
                <button class="btn p-1  btn-success p-0 w-100" wire:click="addToPackage('{{ $products->id }}')">
                    <i class="material-icons">add</i>
                    Agergar
                </button>
                @endif
            </div>
        </div>

        @endforeach

    </div>
</div>