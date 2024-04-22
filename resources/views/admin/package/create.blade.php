@extends('layouts.app',[
'title'=>'Paquetes',
'navbarClass'=>'navbar-transparent',
'activePage'=>'package',
])
@section('content')
@include('includes.spinner')
<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">library_add</i>

                        </div>
                        <h4 class="card-title">Agregar Paquete</h4>
                    </div>
                    <div class="card-body ">
                        <form id="create-package" action="{{ route('package.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="bmd-label-floating" for="title">Titulo</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                    @error('title')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="bmd-label-floating" for="price">Precio publico</label>
                                    <input type="number" class="form-control" name="price" value="{{ old('price') }}" step="0.01">
                                    @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="bmd-label-floating" for="price_with_discount">Precio con descuento</label>
                                    <input type="number" class="form-control" name="price_with_discount" value="{{ old('price_with_discount') }}" step="0.01">
                                    @error('price_with_discount')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                               
                            </div>
                            <div class="form-row   mt-lg-5">
                                <div class="form-group col-12">
                                    <label class="bmd-label-floating">Informacion</label>
                                    <textarea class="form-control border rounded" name="information" rows="5" value="">{{ old('information') }}</textarea>
                                    @error('information')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-row border-bottom text-center mt-5">
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title">Imagen principal</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona La portada</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="itemMain" accept="image/*" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                        </div>
                                    </div>
                                    <div>
                                        @error('itemMain')
                                        <small class=" text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-10 text-center mt-5">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="reset" class="btn">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@include('includes.alert-error')