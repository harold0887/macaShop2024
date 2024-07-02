    @extends('layouts.app',[
    'title'=>'Productos',
    'navbarClass'=>'navbar-transparent',
    'activePage'=>'products',

    ])
    @section('content')
    <div class="content  py-0 bg-white">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <h2 class="title text-center text-primary text-sm sm:text-2x1 md:text-2xl  lg:text-2xl border-bottom">
                        {{ $product->title }}
                        @role('admin')
                        <a class="btn btn-success btn-link p-0" href="{{ route('products.edit', $product->id) }}" target="_blank">
                            <i class="material-icons">edit</i>
                        </a>
                        @endrole
                    </h2>
                </div>
            </div>
            <!--row first-->
            <div class="row justify-content-around">
                <!--col left -->
                <div class="col-12 col-lg-6 ">
                    <div class="row justify-content-center">
                        @if($product->video)
                        <div class="col-5 d-flex justify-content-center  px-2 px-lg-5 pb-5">
                            <video class="rounded  w-100 " src="{{ Storage::url($product->video) }}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                        </div>
                        @endif
                        <div class="@if($product->video) col-7 @else col-11 col-lg-11 @endif">
                            @include('includes.carrusel')
                        </div>
                    </div>


                </div>
                <!--col right -->
                <div class="col-12 col-lg-6 mt-4 mt-lg-0">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="title text-center text-primary text-sm sm:text-2x1 md:text-2xl  lg:text-2xl my-0">Ventas del producto {{$product->sales_count}} </h2>
                        </div>
                        <div class="col-12">
                            <div class="table-responsive ">
                                <table class="table table-striped text-xs">
                                    <thead>
                                        <tr>
                                            <th>Index</th>
                                            <th style="cursor:pointer">

                                                Order
                                            </th>
                                            <th style="cursor:pointer">

                                                Fecha
                                            </th>
                                            <th style="cursor:pointer">
                                                Pago
                                            </th>
                                            <th style="cursor:pointer">
                                                Status
                                            </th>
                                            <th style="cursor:pointer">
                                                Price
                                            </th>



                                            <th>email</th>
                                            <th>WhatsApp</th>
                                            <th>Facebook</th>
                                            <th>Comentario</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->orders as $order)

                                        <tr class=" {{$order->active==0 ? 'table-danger':''}} ">
                                            <td>{{$loop->index+1}} </td>
                                            <td>{{ $order->id }}</td>

                                            <td>{{date_format($order->created_at, 'd-M-Y g:i a')}}</td>
                                            <td>{{ $order->payment_type }}</td>
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
                                            <td>
                                                {{ $order->price }}
                                            </td>


                                            <td>
                                                {{ $order->user->email }}
                                            </td>

                                            <td>
                                                {{ $order->user->whatsapp }}
                                            </td>
                                            <td>
                                                {{ $order->user->facebook }}
                                            </td>



                                            <td>

                                            </td>
                                            <td class="td-actions">
                                                <div class="btn-group m-0 d-flex" style="box-shadow: none !important">
                                                    <!-- <button class="btn btn-info btn-link text-success " onclick="udateData('{{ $order->id }}','nota{{ $order->id }}')">
                                <i class=" material-icons ">save</i>
                            </button> -->
                                                    <a class="btn btn-info btn-link" href="{{ route('sales.show', $order->id) }}" target="_blank">
                                                        <i class=" material-icons">visibility</i>
                                                    </a>
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

            </div>












































        </div>

    </div>




    @endsection