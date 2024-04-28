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
                        <h4 class="card-title">Editar - {{ $membership->title }} </h4>
                    </div>
                    <div class="card-body ">
                        <form action="{{ route('memberships.update', $membership->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PATCH')
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="name">Nombre de la membresia</label>
                                    <input type="text" class="form-control" name="title" value=" {{ $membership->title }} ">
                                    @error('title')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="price">Precio publico</label>
                                    <input type="number" class="form-control" name="price" value="{{ $membership->price }}" step="0.01">
                                    @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="discount">Precio con descuento</label>
                                    <input type="number" class="form-control" name="discount" value="{{ $membership->price_with_discount }}{{ old('discount') }}" step="0.01">
                                    @error('discount')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-row mt-5">
                                <div class="form-group col-12 col-md-4 ">
                                    <select name="vigencia" class="selectpicker form-control" data-size="7" data-style="select-with-transition " title="Vigencia...">
                                        <option disabled>Selecciona una opcion...</option>

                                        <option value="anual" {{ $membership->vigencia == 'anual' ? 'selected' : '' }} {{ old('vigencia') == 'anual' ? 'selected' : '' }}>Anual</option>
                                        <option value="semestral" {{ $membership->vigencia == 'semestral' ? 'selected' : '' }} {{ old('vigencia') == 'semestral' ? 'selected' : '' }}>Semestral</option>
                                        <option value="trimestral" {{ $membership->vigencia == 'trimestral' ? 'selected' : '' }} {{ old('vigencia') == 'trimestral' ? 'selected' : '' }}>Trimestral</option>

                                    </select>
                                    @error('vigencia')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="start">Inicio</label>
                                    <input type="date" class="form-control" name="start" required value="{{ old('start')?: (new DateTime($membership->start))->format('Y-m-d')  }}">
                                    @error('start')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="expiration">Fin</label>
                                    <input type="date" class="form-control" name="expiration" required value="{{ old('expiration')?: (new DateTime($membership->expiration))->format('Y-m-d')  }}">
                                    @error('expiration')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-row mt-5">
                                <div class="form-group col-md-12">
                                    <label for="information">Informacion</label>
                                    <textarea class="form-control border mt-2 rounded" name="information" rows="5" value="">{{ old('information') ?: $membership->information }}</textarea>
                                    @error('information')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title">Imagen principal</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="height:300px !important">
                                            @if ($membership->itemMain && Storage::exists($membership->itemMain))
                                            <img src="{{ Storage::url($membership->itemMain)  }}" alt="...">
                                            @else
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                            <h6 class="m-2">No existe una portada para esta membresia.</h6>
                                            @endif

                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona una nueva portada</span>
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
                            <div class="row">
                                <div class="col-sm-12 text-center  mt-5 ">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="material-icons">autorenew</i>Actualizar</button>
                                    <a class="btn btn-md btn-outline-primary" href="{{ route('memberships.index') }}">
                                        <i class="material-icons">undo</i> Regresar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body ">
                        <livewire:edit-membership />

                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

@endsection