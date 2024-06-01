@extends('layouts.app',[
'title'=>'Registro de asistencia',
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
                    <li class="breadcrumb-item"><a href="{{route('grupos.index')}}">Mis grupos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar {{ $group->escuela }} {{ $group->grado_grupo }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12  mt-4">
            <a class="text-sm" href="{{ route('grupos.index') }}">Regresar a mis grupos.</a>
        </div>
        <div class="col-md-6">
            <div class="card mt-lg-0">
                <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">school</i>
                    </div>
                    <h4 class="card-title">Editar {{ $group->escuela }} {{ $group->grado_grupo }} {{ $group->ciclo_escolar }}</h4>
                </div>
                <div class="card-body ">
                    <form id="create-product-admin" action="{{ route('grupos.update', $group->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="form-group">
                            <label class="bmd-label-floating">Escuela</label>
                            <input type="text" class="form-control" name="escuela" value="{{ old('escuela') ?: $group->escuela }}">
                            @error('escuela')
                            <small class="text-danger"> {{ $message }} </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="bmd-label-floating">Grado y grupo</label>
                            <input type="text" class="form-control" name="grado_grupo" value="{{ old('grado_grupo') ?: $group->grado_grupo }}">
                            @error('grado_grupo')
                            <small class="text-danger"> {{ $message }} </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="bmd-label-floating">Ciclo escolar</label>
                            <input type="text" class="form-control" name="ciclo_escolar" value="{{ old('ciclo_escolar') ?: $group->ciclo_escolar }}">
                            @error('ciclo_escolar')
                            <small class="text-danger"> {{ $message }} </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="bmd-label-floating d-block">Selecciona un color para identificar al grupo</label>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="color" value="primary" checked>
                                    <div class="bg-primary rounded" style="width: 25px !important; height:25px !important"></div>
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="color" value="rose" {{ old('color', $group->color) == 'rose' ? 'checked' : '' }}>
                                    <div class="bg-secondary rounded" style="width: 25px !important; height:25px !important"></div>
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="color" value="info" {{ old('color', $group->color) == 'info' ? 'checked' : '' }}>
                                    <div class="bg-info rounded" style="width: 25px !important; height:25px !important"></div>
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="color" value="success" {{ old('color', $group->color) == 'success' ? 'checked' : '' }}>
                                    <div class="bg-success rounded" style="width: 25px !important; height:25px !important"></div>
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="color" value="danger" {{ old('color', $group->color) == 'danger' ? 'checked' : '' }}>
                                    <div class="bg-danger rounded" style="width: 25px !important; height:25px !important"></div>
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline ">
                                <label class="form-check-label ">
                                    <input class="form-check-input" type="radio" name="color" value="warning" {{ old('color', $group->color) == 'warning' ? 'checked' : '' }}>
                                    <div class="bg-warning rounded" style="width: 25px !important; height:25px !important"></div>
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            @error('color')
                            <small class="text-danger"> {{ $message }} </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="bmd-label-floating">Materia (opcional)</label>
                            <input type="text" class="form-control" name="materia" value="{{ old('materia') ?: $group->materia }}">
                            @error('materia')
                            <small class="text-danger"> {{ $message }} </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="bmd-label-floating">Maestro(a) (opcional)</label>
                            <input type="text" class="form-control" name="maestro" value="{{ old('maestro') ?: $group->maestro }}">
                            @error('maestro')
                            <small class="text-danger"> {{ $message }} </small>
                            @enderror
                        </div>

                        <div class="card-footer ">
                            <button type="submit" class="btn btn-fill btn-primary">Actualizar</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>

    </div>




</div>








@endsection