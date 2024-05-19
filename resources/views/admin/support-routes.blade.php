@extends('layouts.app',[
'title'=>'Rutas',
'navbarClass'=>'navbar-transparent',
'activePage'=>'routes',
])
@section('content')
<div class="content py-0 bg-white">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">alt_route</i>
                        </div>
                        <h4 class="card-title font-weight-bold">Rutas de apoyo.</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-3 text-center">
                                <a class="btn btn-danger w-100" href="{{ route('storage.personal') }}">

                                    <span>Storage link personal</span>

                                </a>
                            </div>
                            <div class="col-12 col-md-3">
                                <a class="btn btn-warning w-100" href="{{ route('storage.link') }}">
                                    <span>Storage link</span>
                                </a>
                            </div>
                            <div class="col-12 col-md-3">
                                <a class="btn btn-rose w-100" href="{{ route('clear-cache') }}">
                                    <span>Clear cache</span>
                                </a>
                            </div>
                            <div class="col-12 col-md-3">
                                <a class="btn btn-info w-100" href="{{ route('view-clear') }}">
                                    <span>View clear</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <livewire:admin.show-payment />




    </div>


</div>



@endsection