@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => '',
'title' =>"thanks you",
'pageBackground' => asset("material").'/img/login.jpg',
'navbarClass'=>'text-primary',
'background'=>'#eee !important'
])

@section('content')

<div class="container-fluid  p-0 ">
    <div class="content-main  rounded">
        @include('includes.borders')
        <div class="row ">
            <div class="col-12 col-md-6 my-3 my-md-5">
                <div class="row">
                    <div class="col-12 col-md-2 text-center ">
                        <i class="fa-regular fa-circle-check fa-3x text-primary"></i>
                    </div>
                    <div class="col-12 col-md-10">
                        <div class="text-center text-md-left">
                            <p>
                                Número de compra <span class="font-weight-bold">{{$order}}</span>
                            </p>
                            <p style="font-size: 1.5rem">
                                <b>Gracias {{Auth::user()->name}}!</b>
                            </p>
                        </div>

                        <div class="border rounded mt-4 p-2">
                            <p class="mb-2">Tu compra esta confirmada</p>
                            <p class="small">
                                Recibirás en breve un correo electrónico de confirmación con tu número de compra.
                            </p>

                        </div>
                        <div class="border rounded mt-4 p-2">
                            <p>Información del cliente</p>
                            <p class="small mt-2">
                                <b>
                                    Contacto
                                </b>
                            </p>
                            <p class="small">
                                {{Auth::user()->email}}
                            </p>
                            <p class="small mt-2">
                                <b>
                                    Método de pago
                                </b>
                            </p>
                            <p class="small">
                                <i class="fa-solid fa-credit-card"></i>
                                {{$payment_type}}
                            </p>
                            <p class="small mt-2">
                                <b>
                                    Método de envio
                                </b>
                            </p>
                            <p class="small">
                                Formato digital
                            </p>

                        </div>
                        <div class="text-center text-md-left mt-3 ">
                            <a href="{{ route('order.show', $order) }}" class="btn   btn-round w-100 text-sm sm:text-base md:text-lg  lg:text-lg" style="background-color: #c09aed;">
                                Descargar materiales comprados
                            </a>
                        </div>
                    </div>
                </div>



            </div>
            @if(isset($productosCart) && $productosCart->count() > 0 )
            <div class="col-12 col-md-6 text-white  rounded-right" style="background-color: #c09aed;">

                @foreach ($productosCart as $item)
                <div class="row pt-2 ">

                    <div class="col-6 col-md-3 my-1">
                        <img src="{{ Storage::url($item->associatedModel->itemMain) }} " class="img-thumbnail">
                    </div>
                    <div class="col-12 col-md-6 text-white">

                        @if ($item->associatedModel->model == 'Product')
                        <b style="font-size: 1.2em">{{ $item->name }}</b>
                        <br>
                        <span >Formato digital: {{ $item->associatedModel->format }}
                        </span>
                        @elseif($item->associatedModel->model == 'Membership')
                        <b style="font-size: 1.2em">Membresia {{ $item->name }}</b>
                        <br>
                        <span >
                            Vigencia:


                            <span>
                                @if(date_format(new DateTime($item->expiration),'M')=='Jan')
                                Enero
                                @elseif(date_format(new DateTime($item->expiration),'M')=='Feb')
                                Febrero
                                @elseif(date_format(new DateTime($item->expiration),'M')=='Mar')
                                Marzo
                                @elseif(date_format(new DateTime($item->expiration),'M')=='Apr')
                                Abril
                                @elseif(date_format(new DateTime($item->expiration),'M')=='May')
                                Mayo
                                @elseif(date_format(new DateTime($item->expiration),'M')=='Jun')
                                Junio
                                @elseif(date_format(new DateTime($item->expiration),'M')=='Jul')
                                Julio
                                @elseif(date_format(new DateTime($item->expiration),'M')=='Aug')
                                Agosto
                                @elseif(date_format(new DateTime($item->expiration),'M')=='Sep')
                                Septiembre
                                @elseif(date_format(new DateTime($item->expiration),'M')=='Oct')
                                Octubre
                                @elseif(date_format(new DateTime($item->expiration),'M')=='Nov')
                                Noviembre
                                @elseif(date_format(new DateTime($item->expiration),'M')=='Dec')
                                Diciembres
                                @endif
                            </span>

                            {{date_format(new DateTime($item->expiration),'Y')}}
                        </span>
                        @elseif($item->associatedModel->model == 'Package')

                        <b style="font-size: 1.2em">{{ $item->name }}</b>
                        <span >
                            {{$item->products}}

                        </span>

                        @endif
                        <br>

                        <span >Precio: ${{ number_format($item->price,2) }} MXN </span> <br>
                        <span >Cantidad: {{ $item->quantity }} </span> <br>


                    </div>




                </div>
                @endforeach
                <div class="row py-2 mt-2 border-top border-info">
                    <div style="font-size: 1.2em" class="col-6 font-weight-bold mt-1 d-flex align-self-center">Total: </div>
                    <div class="col-6  font-weight-bold text-end  text-end" style="font-size: 1.2em">${{ $Total }} MXN</div>
                </div>
            </div>
            @endif



        </div>
        @include('includes.borders')
    </div>
</div>





@endsection