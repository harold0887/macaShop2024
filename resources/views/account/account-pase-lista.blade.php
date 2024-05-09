@extends('layouts.app',[
'title'=>'Pase de lista',
'navbarClass'=>'navbar-transparent',
'activePage'=>'paselista',
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
                    <li class="breadcrumb-item active" aria-current="page">Pase de lista</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="page-categories">
                <ul class="nav nav-pills nav-pills-primary nav-pills-icons justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#link7" role="tablist">
                            <i class="material-icons">info</i> Pase de Lista
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#link8" role="tablist">
                            <i class="material-icons">location_on</i> Evaluaciones
                        </a>
                    </li>

                </ul>
                <div class="tab-content tab-space tab-subcategories  py-0">
                    <div class="tab-pane active " id="link7">
                        <div class="card my-0 ">
                            <div class="card-header">

                                <p class="card-category">
                                    Selecciona un grupo para continuar.
                                </p>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 cards">
                                        <div class="card card-pricing card-raised">
                                            <div class="card-body">
                                                <div style="position: absolute; right:10px">
                                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="material-symbols-outlined">
                                                            more_vert
                                                        </span>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background:#e9e9e8;">
                                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Reportes</a>
                                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Duplicar</a>
                                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Ocultar</a>
                                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Editar</a>
                                                        <a class="dropdown-item" href="{{ route('home') }}">Eliminar</a>
                                                    </div>
                                                </div>

                                                <h6 class="card-category">Colegio Boston</h6>
                                                <div class="card-icon icon-rose">
                                                    <i class="material-icons">home</i>
                                                </div>
                                                <h3 class="card-title">29 Alumnos</h3>
                                                <p class="card-description">
                                                    This is good if your company size is between 2 and 10 Persons.
                                                </p>
                                                <a href="#pablo" class="btn btn-rose btn-round">Seleccionar</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 cards">
                                        <div class="card card-pricing card-plain">
                                            <div class="card-body">
                                                <h6 class="card-category">Crear nuevo Grupo</h6>
                                                <div class="card-icon">
                                                    <i class="material-icons">domain_add</i>
                                                </div>
                                                <h3 class="card-title">FREE</h3>
                                                <p class="card-description">
                                                    This is good if your company size is between 2 and 10 Persons.
                                                </p>
                                                <a href="{{ route('paselista.create') }}" class="btn btn-white btn-round">Choose Plan</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="link8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Location of the product</h4>
                                <p class="card-category">
                                    More information here
                                </p>
                            </div>
                            <div class="card-body">
                                Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                                <br>
                                <br> Dramatically maintain clicks-and-mortar solutions without functional solutions.
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


</div>








@endsection