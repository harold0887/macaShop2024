<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')

    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb my-0 text-xs lg:text-base">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{route('customer.orders')}}">Mis compras</a></li>
                    <li class="breadcrumb-item"><a href="{{route('customer.packages')}}">Paquetes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$package->title}}</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 mt-4 mt-lg-0">
            <h2 class=" text-center text-primary text-base sm:text-2x1 md:text-2xl  lg:text-2xl">
                {{$package->title}}
            </h2>
        </div>

        @if (isset($package) && $package->count() > 0)
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
                                @foreach ($package->products as $product)
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

                                                <span class="d-block  text-muted fst-italic">{{ $product->price }} MXN</span>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row mx-0">
                                            <div class="col-12">
                                                @if ($order->status == 'approved')
                                                @if($product->folio == 1 && $order->active == 0 )
                                                <span class="d-block fw-bold">Este documento requiere activación.</span>
                                                <span class="d-block my-2">Da clic en el logo de WhatsApp para enviar un mensaje y solicitar la activación.</span>
                                                <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20orden%20de%20compra%20web: {{ $order->id }}" target="_blank">
                                                    <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                </a>
                                                @else
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
                                                @endif
                                                @else
                                                <button class="btn btn-outline-primary btn-round" disabled>
                                                    <i class=" material-icons">file_download</i>
                                                    No disponible
                                                </button>
                                                @endif
                                            </div>
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
            <span class="h4 text-muted">Aún no ha realizado ninguna compra, visite <a href=" {{ route('paquete') }} ">nuestra tienda</a> para comprar su primer paquete de materiales didácticos. <span>
        </div>
        <div class="col-12 text-center mt-5">
            <a href="{{ route('paquete') }}" class="text-white btn btn-primary btn-lg btn-round">
                <div class="d-flex align-items-center">
                    <i class="material-icons  mr-2 ">shopping_bag</i>
                    <span class="fw-bold">Ver tienda</span>
                </div>

            </a>
        </div>
        @endif
    </div>

</div>