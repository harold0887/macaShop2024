@extends('layouts.app',[
'title'=>'Mis membresías',
'navbarClass'=>'navbar-transparent',
'activePage'=>'memberships',
'menuParent'=>'orders',
])
@section('content')
<div class="content py-0 bg-white">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb my-0 text-xs lg:text-base">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{route('customer.orders')}}">Mis compras</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Membresías</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 mt-4 mt-lg-0">
            <h2 class=" text-center text-primary text-base sm:text-2x1 md:text-2xl  lg:text-2xl">
                Mis membresías
            </h2>
        </div>

        @if (isset($memberships) && $memberships->count() > 0)
        <div class="col-12">
            <div class="card mt-0" id="orders">
                <div class="card-body  px-0">
                    <div class="table-responsive px-0">
                        <table class="table table-hover table-shopping table-striped ">
                            <thead>
                                <tr>
                                    <th class="fw-bold text-muted">Acciones</th>
                                    <th class="fw-bold text-muted">Nombre</th>
                                    <th class="fw-bold text-muted">status</th>
                                    <th class="fw-bold text-muted">Número de Compra</th>
                                    <th class="fw-bold text-muted">Fecha de Expiracion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($memberships as $item)

                                <tr>
                                    @if( $item->membership_id==2013)
                                    <td>

                                    </td>
                                    @else
                                    <td>
                                        <a href="{{ route('customer.membership-show', ['id'=>$item->membership_id]) }}" class=" text-white btn  btn-primary rounded">
                                            <span>Ver detalle</span>
                                        </a>
                                    </td>
                                    @endif

                                    <td>
                                        <div class="row">
                                            <div class="col-12 col-lg-auto">
                                                <div class="img-container ">
                                                    <img src="{{ Storage::url($item->membership->itemMain) }}" alt="{{ $item->membership->title }}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-auto">
                                                <span class="d-block fw-bold  text-muted mt-2 text-sm md:text-base  lg:text-base">{{ $item->membership->title }}</span>
                                                <span class="d-block  text-muted fst-italic">{{ $item->price }} MXN</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($item->membership->expiration > now())
                                        <span class="d-flex d-block text-success align-items-center">
                                            <i class="material-icons mr-1">check_circle</i> Vigente
                                        </span>
                                        @else
                                        <span class="d-flex d-block text-danger align-items-center">
                                            <i class="material-icons mr-1">cancel</i>Expirada
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$item->order->id}}
                                    </td>
                                    <td>
                                        @if( $item->membership_id==2013)
                                        -
                                        @else
                                        {{date_format(new DateTime($item->membership->expiration),'d-M-Y')}}
                                        @endif

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
            <span class="h4 text-muted">Aún no ha realizado ninguna compra, visite <a href=" {{route('membership')}} ">nuestra tienda</a> para comprar su primera primera membresía. <span>
        </div>
        <div class="col-12 text-center mt-5">
            <a href="{{route('membership')}}" class="text-white btn btn-primary btn-lg btn-round">
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