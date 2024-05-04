@extends('layouts.app',[
'title'=>'Membresias',
'navbarClass'=>'navbar-transparent',
'activePage'=>'memberships',
])
@section('content')
<div class="content pt-0">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">card_membership</i>
                        </div>
                        <h4 class="card-title">Agregar membresia </h4>
                    </div>
                    <div class="card-body">
                        <form id="create-membership-admin" action="{{ route('memberships.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="bmd-label-floating">Nombre de la membresia</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                    @error('title')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="bmd-label-floating">Precio publico </label>
                                    <input type="number" class="form-control" name="price" value="{{ old('price') }}" step="0.01">
                                    @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="bmd-label-floating">Precio con descuento</label>
                                    <input  type="number" class="form-control" name="price_discount" value="{{ old('price_discount') }}" step="0.01">
                                    @error('price_discount')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-row mt-5">
                                <div class="form-group col-12 col-md-4 ">
                                    <select name="vigencia" class="selectpicker form-control" data-size="7" data-style="select-with-transition " title="Vigencia...">
                                        <option disabled>Selecciona una opcion...</option>

                                        <option value="anual" {{ old('vigencia') == 'anual' ? 'selected' : '' }}>Anual</option>
                                        <option value="semestral" {{ old('vigencia') == 'semestral' ? 'selected' : '' }}>Semestral</option>
                                        <option value="trimestral" {{ old('vigencia') == 'trimestral' ? 'selected' : '' }}>Trimestral</option>

                                    </select>
                                    @error('vigencia')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="start">Inicio</label>
                                    <input type="date" class="form-control" name="start" value="{{ old('start') }}">
                                    @error('start')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="expiration">Fin</label>
                                    <input type="date" class="form-control" name="expiration" value="{{ old('expiration') }}">
                                    @error('expiration')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                            </div>



                            <div class="form-row mt-5">
                                <div class="form-group col-md-12 ">
                                    <label class="bmd-label-floating" for="information">Informacion</label>
                                    <textarea class="ckeditor form-control border rounded mt-2" name="information" rows="5" value="">{{ old('information') }}</textarea>
                                    @error('information')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
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
                            <div class="col-12 text-center">
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