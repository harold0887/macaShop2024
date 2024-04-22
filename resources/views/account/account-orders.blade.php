@extends('layouts.app',[
'title'=>'Mis compras',
'navbarClass'=>'navbar-transparent',
'activePage'=>'orders',
'menuParent'=>'orders',
])
@section('content')
<div class="content py-0 bg-white">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb my-0 text-xs lg:text-base">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{route('profile.edit')}}">Cuenta</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mis compras</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 mt-4 mt-lg-0">
            <h2 class=" text-center text-primary text-base sm:text-2x1 md:text-2xl  lg:text-2xl">
                Mis compras
            </h2>
        </div>
        @if (isset($orders) && $orders->count() > 0)
        <div class="col-12">
            <div class="card mt-0" id="orders">

                <div class="card-body  px-0">

                    <div class="table-responsive px-0">
                        <table class="table table-hover table-shopping table-striped ">
                            <thead>
                                <tr>
                                    <th class="fw-bold text-muted">Acciones</th>
                                    <th class="fw-bold text-muted">Status de pago</th>
                                    <th class="fw-bold text-muted">Número de Compra</th>
                                    <th class="fw-bold text-muted">Fecha de compra</th>
                                    <th class="fw-bold text-muted">Cantidad</th>
                                    <th class="fw-bold text-muted">Forma de Pago</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('order.show', $order->id) }}" class=" text-white btn  btn-primary rounded">
                                            <span>Ver detalle</span>
                                        </a>
                                    </td>
                                    <td>

                                        @if($order->status == 'create')
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="material-icons mr-1">pending_actions</i>Pendiente de pago
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

                                    </td>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        {{date_format($order->created_at, 'd-M-Y H:i')}}
                                    </td>
                                    <td>{{ $order->amount }}</td>
                                    <td>{{ $order->payment_type }}</td>


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
            <span class="h4 text-muted">Aún no ha realizado ninguna compra, visite <a href=" {{ route('shop.index') }} ">nuestra tienda</a> para comprar su primer producto. <span>
        </div>
        <div class="col-12 text-center mt-5">
            <a href="{{ route('shop.index') }}" class="text-white btn btn-primary btn-lg btn-round">
                <div class="d-flex align-items-center">
                    <i class="material-icons  mr-2 ">shopping_bag</i>
                    <span class="fw-bold">Ver tienda</span>
                </div>

            </a>
        </div>
        @endif
    </div>

</div>








@endsection