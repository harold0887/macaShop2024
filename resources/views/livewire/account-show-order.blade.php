@php
// SDK de Mercado Pago
require base_path('vendor/autoload.php');
// Agrega credenciales
MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();
// declarar el array vacio
$products=[];

// Crea un ítem en la preferencia

//recorrer la orden de productos, paquetes y membresías


if(isset($purchases) && $purchases->count() > 0)
{
foreach ($purchases as $prod) {
$item = new MercadoPago\Item();
$item->title = $prod->product->title;
$item->quantity = 1;
$item->unit_price = $prod->price;
$products[]= $item;
}
};


if(isset($packages) && $packages->count() > 0)
{
foreach ($packages as $prod) {
$item = new MercadoPago\Item();
$item->title = $prod->package->title;
$item->quantity = 1;
$item->unit_price = $prod->price;
$products[]= $item;
}
};


if(isset($memberships) && $memberships->count() > 0)
{
foreach ($memberships as $prod) {
$item = new MercadoPago\Item();
$item->title = $prod->membership->title;
$item->quantity = 1;
$item->unit_price = $prod->price;
$products[]= $item;
}
};

if($products !=null)
{
$preference->items = $products;
//redirigir segun el resultado
$preference->back_urls = array(
"success" => route('shop.thanks'),
"failure" => route('shop.thanks'),
"pending" => route('shop.thanks'),
);



//mandar la orden_id

$preference->external_reference=$order->id;


//regresar automaticamente al ser approved
$preference->auto_return = "approved";
$preference->notification_url = "https://materialdidacticomaca.com/webhooks-arnold";




$preference->save();
}







@endphp






<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')

    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb my-0 text-xs lg:text-base">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{route('profile.edit')}}">Cuenta</a></li>
                    <li class="breadcrumb-item"><a href="{{route('customer.orders')}}">Mis compras</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Compra: {{ $order->id }} </li>
                </ol>
            </nav>
        </div>
        <div class="col-12 mt-4 mt-lg-0">
            <h2 class=" text-center text-primary text-base sm:text-2x1 md:text-2xl  lg:text-2xl">
                Número de compra: {{ $order->id }}
            </h2>
        </div>

        <div class="col-12">
            <h5 class="text-muted">Total: {{ number_format($order->amount,2) }} MXN </h4>
        </div>



        <div class="col-auto  d-flex align-items-center pr-0">

        </div>
        <div class="col-auto d-flex align-items-center">
            <span class="text-muted mr-1 d-inline">
                Status de pago:
            </span>
            @if($order->status == 'create')

            <div class="d-inline d-flex align-items-center text-muted">
                <i class="material-icons mr-1">pending_actions</i>Pendiente
            </div>
            @elseif ($order->status == 'approved')
            <div class="d-flex align-items-center text-success">
                <i class="material-icons mr-1">check_circle</i>Aprobado
            </div>
            @elseif($order->status == 'pending')
            <div class="d-flex align-items-center text-muted">
                <i class="material-icons mr-1">pending</i>Deposito pendiente
            </div>
            @elseif($order->status == 'in_process')
            <div class="d-flex align-items-center text-muted">
                <i class="material-icons mr-1">watch_later</i>En proceso.
            </div>
            @elseif($order->status == 'cancelled')
            <div class="d-flex align-items-center text-danger">
                <i class="material-icons mr-1">cancel_presentation</i>Cancelado
            </div>
            @elseif($order->status == 'rejected')
            <div class="d-flex align-items-center text-danger">
                <i class="material-icons mr-1">cancel</i>Rechazado
            </div>
            @elseif($order->status == 'refunded')
            <div class="d-flex align-items-center text-danger">
                <i class="material-icons mr-1">settings_backup_restore</i>Reembolsado
            </div>
            @elseif($order->status == 'charged_back')
            <div class="d-flex align-items-center text-danger">
                <span class="material-symbols-outlined mr-1">
                    send_money
                </span>
                Contracargo
            </div>
            @endif
        </div>
        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
            @if($order->status == 'create')
            <div class="cho-container ">

            </div>
            @endif
        </div>


        <div class="col-12">
            <div class="card ">

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
                                @if (isset($purchases) && $purchases->count() > 0)
                                @foreach ($purchases as $item)
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-12 col-lg-auto">
                                                <div class="img-container">
                                                    <img src="{{ Storage::url($item->product->itemMain) }}" alt="{{ $item->product->title }}">

                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-auto">
                                                <span class="d-block fw-bold  text-muted mt-2 text-sm md:text-base  lg:text-base">{{ $item->product->title }}</span>
                                                <span class="d-block  text-muted my-1">Archivo en formato {{ $item->product->format }}</span>
                                                <span class="d-block  text-muted fst-italic">{{ $item->price }} MXN</span>
                                            </div>
                                        </div>


                                    </td>
                                    <td>
                                        <div class="row mx-0">
                                            <div class="col-12">
                                                @if ($order->status == 'approved')
                                                @if($item->product->folio == 1 && $order->active == 0 )
                                                <span class="d-block fw-bold">Este documento requiere activación.</span>
                                                <span class="d-block my-2">Da clic en el logo de WhatsApp para enviar un mensaje y solicitar la activación..</span>
                                                <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20orden%20de%20compra%20web: {{ $order->id }}" target="_blank">
                                                    <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                </a>

                                                @else
                                                <div wire:loading.remove>
                                                    <div>
                                                        <button class="btn btn-outline-info btn-round " wire:click="finalDownload({{ $item->product->id }})" wire:loading.attr="disabled">
                                                            <i class="material-icons">download</i> Descargar
                                                        </button>
                                                    </div>
                                                    <div class="mt-3">
                                                        <button class="btn btn-outline-primary btn-round btn-link" wire:click="sendEmail({{ $item->product->id }},{{ $item->order_id }})">
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
                                @endif




                                @if (isset($packages) && $packages->count() > 0)
                                @foreach ($packages as $item)
                                <tr>

                                    <td>
                                        <div class="row">
                                            <div class="col-12 col-lg-auto">
                                                <div class="img-container ">
                                                    <img src="{{ Storage::url($item->package->itemMain) }}" alt="{{ $item->package->title }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-auto">
                                                <span class="d-block fw-bold  text-muted mt-2 text-sm md:text-base  lg:text-base">{{ $item->package->title }}</span>
                                                <span class="d-block  text-muted my-1">{{$item->package->products->count()}} materiales didácticos incluidos. </span>
                                                <span class="d-block  text-muted fst-italic">{{ $item->price }} MXN</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row mx-0">
                                            <div class="col-12">
                                                @if ($order->status == 'approved')
                                                <a href="{{ route('customer.packages-show',['id'=>$item->package->id]) }}" class="btn btn-outline-primary btn-round ">
                                                    Ver materiales
                                                </a>
                                                @else
                                                <button class="btn btn-outline-primary btn-round" disabled>
                                                    <i class="material-icons">visibility_off</i> Ver materiales
                                                </button>
                                                @endif
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                                @endif


                                @if (isset($memberships) && $memberships->count() > 0)
                                @foreach ($memberships as $item)

                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-12 col-lg-auto">
                                                <div class="img-container ">
                                                    <img src="{{ Storage::url($item->membership->itemMain) }}" alt="{{ $item->membership->title }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-auto">
                                                <span class="d-block fw-bold  text-muted mt-2 text-sm md:text-base  lg:text-base">{{ $item->membership->title }}</span>
                                                <span class="d-block  text-muted my-1">Membresía</span>
                                                <span class="d-block  text-muted fst-italic">{{ $item->price }} MXN</span>
                                            </div>
                                        </div>


                                    </td>
                                    <td>
                                        <div class="row mx-0">
                                            <div class="col-12 ">





                                                @if ($order->status == 'approved')
                                                @if ($item->membership->expiration > now())
                                                @if($order->active == 0)
                                                <span class="d-block fw-bold">La membresía requiere activación.</span>
                                                <span class="d-block my-2">Da clic en el logo de WhatsApp para enviar un mensaje y solicitar la activación..</span>
                                                <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20membres%C3%ADa%20{{$item->membership->title}}%20-%20compra%20web: {{ $order->id }} - {{auth()->user()->email}} " target="_blank">
                                                    <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                </a>
                                                @else
                                                <a href="{{ route('customer.membership-show', ['order' => $order->id,'id'=>$item->membership->id]) }}" class="btn btn-outline-primary btn-round">
                                                    Ver materiales
                                                </a>
                                                @endif
                                                @else
                                                <button class="btn btn-outline-danger btn-round" disabled>
                                                    <div class="d-flex align-items-center">
                                                        <i class="material-icons">visibility_off</i> La membresía ha expirado
                                                    </div>
                                                </button>
                                                @endif
                                                @else
                                                <button class="btn btn-outline-primary btn-round" disabled>
                                                    <div class="d-flex align-items-center">
                                                        <i class="material-icons">visibility_off</i> Ver materiales
                                                    </div>

                                                </button>
                                                @endif
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')


<script src="https://sdk.mercadopago.com/js/v2"></script>

<script>
    // Agrega credenciales de SDK
    const mp = new MercadoPago("{{config('services.mercadopago.key')}}", {
        locale: "es-MX",
    });

    // Inicializa el checkout
    mp.checkout({
        preference: {
            id: "{{$preference->id}}",
        },
        render: {
            container: ".cho-container", // Indica el nombre de la clase donde se mostrará el botón de pago
            label: "Finalizar el pago de mi compra", // Cambia el texto del botón de pago (opcional)
        },
    });
</script>




@endpush
@include('includes.alert-error')