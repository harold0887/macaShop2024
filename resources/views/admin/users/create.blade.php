@extends('layouts.app',[
'title'=>'Usuarios',
'navbarClass'=>'navbar-transparent',
'activePage'=>'users',
])
@section('content')

<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">people</i>
                        </div>
                        <h4 class="card-title">Registrar nuevo usuario
                            <h4>

                    </div>
                    <div class="card-body ">
                        <div class="row">

                            <div class="col mr-auto">

                                <form id="create-product-admin" action="{{ route('users.store') }}" method="POST">
                                    @csrf

                                    <div class="form-row ">
                                        <div class="form-group col-12 col-md-4">
                                            <label class="bmd-label-floating">Nombre completo</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                            @error('name')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="form-row ">
                                        <div class="form-group col-12 col-md-4">
                                            <label class="bmd-label-floating">{{ __('Email') }}</label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                            @error('email')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row ">
                                        <div class="form-group col-12 col-md-4">
                                            <label class="bmd-label-floating">WhatsApp</label>
                                            <input type="text" class="form-control" name="whatsapp" value="{{ old('whatsapp') }}">
                                            @error('whatsapp')
                                            <small class="text-danger"> {{ $message }} </small>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="text-center mb-3">
                                        <button type="submit" class="btn btn-primary btn-round mt-4 btn-lg">Crear usuario</button>
                                    </div>



                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection