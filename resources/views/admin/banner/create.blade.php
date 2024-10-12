@extends('layouts.app',[
'title'=>'Banners',
'navbarClass'=>'navbar-transparent',
'activePage'=>'banners',
])
@section('content')
<div class="content pt-0">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">photo_library</i>
                        </div>
                        <h4 class="card-title">Agregar Banner</h4>
                    </div>
                    <div class="card-body ">
                        <form id="create-product-admin" action="{{ route('banners.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-row ">
                                <div class="form-group col-12 col-md-4">
                                    <label class="bmd-label-floating">Titulo</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                    @error('title')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title">Desktop</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona el banner desktop</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="desktop" accept="image/*" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                        </div>
                                    </div>
                                    <div>
                                        @error('desktop')
                                        <small class=" text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title">Mobile</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona el banner mobile</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="mobile" accept="image/*" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                        </div>
                                    </div>
                                    <div>
                                        @error('mobile')
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
    @endsection