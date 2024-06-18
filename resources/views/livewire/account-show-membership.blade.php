<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')


    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb my-0 text-xs lg:text-base">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{route('customer.orders')}}">Mis compras</a></li>
                    <li class="breadcrumb-item"><a href="{{route('customer.memberships')}}">Membresias</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$membership->title}}</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 mt-4 mt-lg-0">
            <h2 class=" text-center text-primary text-base sm:text-2x1 md:text-2xl  lg:text-2xl">
                {{$membership->title}}
            </h2>
        </div>

        @if(now() >= $membership->expiration)
        <div class="col-12 mt-5 text-center">
            <span class="d-block fw-bold text-muted mb-3">La membresía {{$membership->title}} finalizó el {{date_format(new DateTime($membership->expiration),'d-M-Y')}}.</span>
            <span class="h4 text-muted">Quizá quiera conocer alguna de nuestras <a href=" {{ route('membership') }} "> membresías vigentes</a>. <span>
        </div>
        <div class="col-12 text-center mt-5">
            <a href="{{ route('membership') }}" class="text-white btn btn-primary btn-lg btn-round">
                <div class="d-flex align-items-center">
                    <i class="material-icons  mr-2 ">shopping_bag</i>
                    <span class="fw-bold">Ver tienda</span>
                </div>

            </a>
        </div>
        @else
        @if($order->status == 'approved' && $order->active == 0)
        <div class="col-12 text-center mt-5">
            <span class="d-block fw-bold">La membresía {{$membership->title}} requiere activación.</span>
            <span class="d-block my-3"> Da clic en el logo de WhatsApp para enviar un mensaje y solicitar la activación..</span>

            <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20membres%C3%ADa%20{{$membership->title}}%20-%20compra%20web: {{ $order->id }} - {{auth()->user()->email}} " target="_blank">
                <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
            </a>
        </div>
        @else




        @if (isset($products) && $products->count() > 0)
        <div class="col-12 text-muted">
            Ordernar Por:
            <br>
            <button type="button" class="btn btn-sm  mx-0 px-2  {{$sortDirection=='asc' && $sortField=='numero' ? 'btn-success ' :'btn-outline-info'}}" wire:click="setSort('numero', 'asc')">Número (A-Z)</button>
            <button type="button" class="btn btn-sm  mx-0 px-2  {{$sortDirection=='desc' && $sortField=='numero' ? 'btn-success ' :'btn-outline-info'}}" wire:click="setSort('numero', 'desc')">Número (Z-A)</button>
            <button type="button" class="btn btn-sm  mx-0 px-2  {{$sortDirection=='asc' && $sortField=='title' ? 'btn-success ' :'btn-outline-info'}}" wire:click="setSort('title', 'asc')">Nombre (A-Z)</button>
            <button type="button" class="btn btn-sm  mx-0 px-2  {{$sortDirection=='desc' && $sortField=='title' ? 'btn-success ' :'btn-outline-info'}}" wire:click="setSort('title', 'desc')">Nombre (Z-A)</button>

        </div>
        <div class="col-12">
            <div class="card mt-0">
                <div class="card-body px-0">
                    <div class="table-responsive px-0">
                        <table class="table table-hover table-shopping table-striped ">
                            <thead>
                                <tr>
                                    <th class="fw-bold text-muted">Producto</th>
                                    <th class="fw-bold text-muted pl-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-12 col-lg-auto">
                                                <div class="img-container">
                                                    <img src="{{ Storage::url($product->itemMain) }}" alt="{{ $product->title }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-auto">
                                                <span class="d-block fw-bold  text-muted mt-2 text-sm md:text-base  lg:text-base">{{ $product->title }}</span>
                                                <span class="d-block  text-muted my-1">Archivo en formato {{ $product->format }}</span>
                                                <span class="d-block  text-muted fst-italic">{{ $product->numero }}</span>
                                                @role('admin')
                                                <span class="d-block  text-muted fst-italic">{{ $product->folio == 1 ?'folio: true' : 'folio: false'  }}</span>
                                                @endrole



                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row mx-0">

                                            @if(now() >= $product->fecha_membresia)
                                            <div class="col-12">
                                                <div wire:loading.remove>
                                                    <div>
                                                        <button class="btn btn-outline-info btn-round " wire:click="finalDownload({{ $product->id }})" wire:loading.attr="disabled">
                                                            <i class="material-icons">download</i> Descargar
                                                        </button>
                                                    </div>
                                                    <div class="mt-3">
                                                        <button class="btn btn-outline-primary btn-round btn-link" wire:click="sendEmail({{ $product->id }})">
                                                            Enviar a email
                                                        </button>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div>
                                                        <button class="btn btn-outline-primary btn-round " disabled wire:loading wire:target="sendEmail">
                                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                            enviando...
                                                        </button>
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-outline-info btn-round " disabled wire:loading wire:target="finalDownload">
                                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                            Descargando...
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-12 ">

                                                <span class="text-primary text-base">Disponible a partir del {{date_format(new DateTime($product->fecha_membresia),'d-M-Y')}}</span>

                                            </div>

                                            @endif






                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-12 mt-5 text-center">
            <span class="h4 text-muted">Aún no hay materiales didácticos disponibles, por favor espere a que inicie la membresía el {{date_format(new DateTime($membership->start),'d-M-Y')}}. <span>
        </div>
        @endif
        @endif
        @endif
    </div>

</div>