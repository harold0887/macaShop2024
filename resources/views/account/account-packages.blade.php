@extends('layouts.app',[
'title'=>'Mis paquetes',
'navbarClass'=>'navbar-transparent',
'activePage'=>'packages',
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
                    <li class="breadcrumb-item active" aria-current="page">Paquetes</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 mt-4 mt-lg-0">
            <h2 class=" text-center text-primary text-base sm:text-2x1 md:text-2xl  lg:text-2xl">
                Mis paquetes
            </h2>
        </div>
        @if (isset($packages) && $packages->count() > 0)
        <div class="col-12">
            <div class="card mt-0" id="orders">
                <div class="card-body  px-0">
                    <div class="table-responsive px-0">
                        <table class="table table-hover table-shopping table-striped ">
                            <thead>
                                <tr>
                                    <th class="fw-bold text-muted">Acciones</th>
                                    <th class="fw-bold text-muted">Nombre</th>
                                    <th class="fw-bold text-muted">Número de Compra</th>
                                    <th class="fw-bold text-muted">Fecha de compra</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packages as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('customer.packages-show',['id'=>$item->package_id]) }}" class=" text-white btn  btn-primary rounded">
                                            <span>Ver detalle</span>
                                        </a>
                                    </td>
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
                                        {{$item->order->id}}
                                    </td>
                                    <td>
                                        {{date_format($item->order->created_at, 'd-M-Y')}}
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









@endsection