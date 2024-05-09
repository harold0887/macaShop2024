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
                    <li class="breadcrumb-item"><a href="{{route('profile.edit')}}">Pase de lista</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Crear grupo</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="page-categories">

                <div class="tab-content tab-space tab-subcategories">
                    <div class="tab-pane active " id="link7">
                        <div class="card my-0 ">
                            <div class="card-header">

                                <p class="card-category">
                                    Regresar a mis grupos.
                                </p>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center">
                                   
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>


</div>








@endsection