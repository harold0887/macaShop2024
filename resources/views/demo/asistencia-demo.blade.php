@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'asistencia',
'title' =>"Asistencia",
'pageBackground' => asset("material").'/img/login.jpg',
'navbarClass'=>'text-primary ',
'background'=>'#eee !important'
])

@section('content')
<div class="container bg-white shadow my-1 rounded">
    <div class="content-main ">
        <div class="content-main">
            <div class="row ">
                <div class="col-12">
                    <nav aria-label="breadcrumb ">
                        <ol class="breadcrumb my-0 text-xs lg:text-base">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Tienda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Registro de asistencia</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h1 class=" lg:pt-5 pt-4 md:text-3xl  text-center  text-xl text-muted">
                        <span class="fw-bold text-primary">Un sistema de control de asistencia moderno y efectivo</span>
                    </h1>
                </div>
            </div>
            <div class="row justify-content-around">

                <div class=" col-4 nav nav-pills  nav-pills-icons justify-content-center p-0">
                    <div class="nav-item ">
                        <button class="nav-link border" data-toggle="modal" data-target="#exampleModal15">
                            <i class="material-icons text-info">info</i> informacion
                        </button>

                    </div>
                </div>
                <div class=" col-4 nav nav-pills  nav-pills-icons justify-content-center p-0">
                    <div class="nav-item ">
                        <button class="nav-link border" data-toggle="modal" data-target="#exampleModal16">
                            <i class="fa fa-youtube-play text-primary"></i>Demostracion
                        </button>
                    </div>
                </div>
                <div class=" col-4 nav nav-pills  nav-pills-icons justify-content-center p-0">
                    <div class="nav-item ">
                        <button class="nav-link border">
                            <i class="material-icons">help_outline</i> Preguntas
                        </button>
                    </div>
                </div>

                <!-- <div class="col-4 border border-danger px-0">
                    <div class="nav nav-pills  nav-pills-icons justify-content-center border ">
                        <div class="nav-item border border-info">
                            <a class="nav-link">
                                <i class="material-icons">video_label</i>Demostracion
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-4 border border-danger px-0">
                    <div class="nav nav-pills  nav-pills-icons justify-content-center border ">
                        <div class="nav-item border border-info">
                            <a class="nav-link">
                                <i class="material-icons">help_outline</i> Preguntas frecuentes
                            </a>
                        </div>
                    </div>
                </div> -->

            </div>




            <div class="row justify-content-center">
                <div class="col-md-4 col-sm-6 px-3 mb-5">
                    <div class="pricingTable rounded shadow">
                        <h3 class="title">BASIC</h3>
                        <div class="price-value">
                            <h3 class="card-title">Gratis</h3>
                            <span class="text-base text-white">-</span>
                        </div>
                        <ul class="pricing-content text-start">
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-success">
                                    check
                                </span>
                                Registro de asistencia
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-success">
                                    check
                                </span>
                                Registro de evaluaciones
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-success">
                                    check
                                </span>
                                1 grupo
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-success">
                                    check
                                </span>
                                25 alumnos por grupo
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-danger">
                                    close
                                </span>
                                Exportar reportes en PDF
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-danger">
                                    close
                                </span>
                                Exportar reportes en Excel
                            </li>


                        </ul>
                        <button class=" btn  btn-primary btn-round  w-full btn-lg " wire:loading.attr="disabled">
                            <div class="d-flex align-items-center ">
                                <i class="material-icons mr-2 ">shopping_cart</i>
                                <span class="text-xs fw-bold">Iniciar prueba</span>
                            </div>
                        </button>

                    </div>
                </div>
                <div class="col-md-4 col-sm-6 px-3 mb-5">
                    <div class="pricingTable pink shadow">
                        <h3 class="title">PRO</h3>
                        <div class="price-value">
                            <h3 class="card-title">180.00 MXN</h3>

                            <span class="text-base">Pago unico</span>
                        </div>
                        <ul class="pricing-content text-start">
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-success">
                                    check
                                </span>
                                Registro de asistencia
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-success">
                                    check
                                </span>
                                Registro de evaluaciones
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-success">
                                    check
                                </span>
                                grupos ilimitados
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-success">
                                    check
                                </span>
                                alumnos ilimitados por grupo
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-success">
                                    check
                                </span>
                                Exportar reportes en PDF
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="material-symbols-outlined mr-2 text-success">
                                    check
                                </span>
                                Exportar reportes en Excel
                            </li>


                        </ul>
                        <button class=" btn  btn-primary btn-round  w-full btn-lg " wire:loading.attr="disabled">
                            <div class="d-flex align-items-center ">
                                <i class="material-icons mr-2 ">shopping_cart</i>
                                <span class="text-xs fw-bold">Agregar al carrito</span>
                            </div>
                        </button>
                    </div>
                </div>

            </div>






        </div>



















    </div>
</div>






@endsection