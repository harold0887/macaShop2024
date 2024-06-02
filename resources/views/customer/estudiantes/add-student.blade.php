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
                    <li class="breadcrumb-item"><a href="{{route('grupos.index')}}">Mis grupos</a></li>
                    <li class="breadcrumb-item"><a href="{{route('grupos.index')}}">{{$group->escuela}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Agregar estudiante</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12  mt-4">
            <a class="text-sm" href="{{ route('grupos.index') }}">Regresar a mis grupos.</a>
        </div>
        <div class="col-md-6">
            <!--      Wizard container        -->
            <div class="wizard-container">
                <div class="card card-wizard mt-lg-0" data-color="blue" id="wizardProfile">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">school</i>
                        </div>
                        <h4 class="card-title text-base sm:text-2x1 md:text-2xl  lg:text-2xl">Agregar estudiante al grupo {{$group->grado_grupo}} - {{$group->escuela}} </h4>
                    </div>
                    <form id="create-new-student" action="{{ route('estudiantes.store') }}" method="POST">
                        @csrf
                        <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="card-header text-center mt-3">

                            <h5 class="card-description text-base ">Esta información nos ayudara a crear el perfil del estudiante.</h5>
                        </div>
                        <div class="wizard-navigation">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#about" data-toggle="tab" role="tab">
                                        Datos generales
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#address" data-toggle="tab" role="tab">
                                        Informacion adicional
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content pt-2">
                                <div class="tab-pane active" id="about">

                                    <div class="row justify-content-center">

                                        <div class="col-sm-6">
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="material-icons">face</i>
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Nombre(s)*</label>
                                                    <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required>
                                                    @error('firstname')
                                                    <small class="text-danger"> {{ $message }} </small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="material-icons">face</i>
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Apellidos*</label>
                                                    <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required>
                                                    @error('lastname')
                                                    <small class="text-danger"> {{ $message }} </small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="material-icons">wc</i>
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Género*</label>
                                                    <div class="checkbox-radios">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="genero" value="M" {{ (old('genero') == "M") ? "checked" : ""}} required>Masculino
                                                                <span class="circle">
                                                                    <span class="check"></span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="genero" value="F" {{ (old('genero') == "F") ? "checked" : ""}} required>Femenino
                                                                <span class="circle">
                                                                    <span class="check"></span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @error('genero')
                                                    <small class="text-danger"> {{ $message }} </small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="material-icons">calendar_month</i>
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Fecha de nacimiento *</label>
                                                    <input type="date" class="form-control" name="nacimiento" value="{{ old('nacimiento') }}" required>
                                                </div>
                                                @error('nacimiento')
                                                <small class="text-danger"> {{ $message }} </small>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-sm-4">
                                            <div class="picture-container">
                                                <div class="picture">
                                                    <img src="{{ asset('material') }}/img/placeholder.jpg" class="picture-src" id="wizardPicturePreview" title="" />
                                                    <input type="file" id="wizard-picture" name="image">
                                                </div>
                                                <h6 class="description">Elegir foto (opcional)</h6>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="tab-pane " id="address">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12  ">
                                            <h5 class="info-text mb-2">Datos de contacto padre, madre o tutor.</h5>
                                        </div>


                                        <div class="col-12 col-lg-5">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Teléfono 1 (opional)</label>
                                                <input type="text" class="form-control" value="{{ old('phone1') }}" name="phone1">

                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-5">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Teléfono 2 (opional)</label>
                                                <input type="text" class="form-control" value="{{ old('phone2') }}" name="phone2">
                                            </div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Email (opcional)</label>
                                                <input type="email" class="form-control" value="{{ old('email1') }}" name="email1">
                                                @error('email1')
                                                <small class="text-danger"> {{ $message }} </small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12  ">
                                            <h5 class="info-text ">Condiciones diferentes.</h5>
                                        </div>


                                        <div class="col-12 col-lg-10">
                                            <select class="selectpicker" name="condiciones[]" data-style="select-with-transition" multiple title="Seleccionar" data-size="7">
                                                @foreach($condiciones as $condicion)
                                                <option value=" {{ $condicion->id }}" {{ (collect(old('condiciones'))->contains($condicion->id)) ? 'selected':'' }}>
                                                    {{ $condicion->condicion }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Comentarios (opcional)</label>
                                                <textarea class="form-control border rounded" name="comentarios" rows="5" value="">{{ old('comentarios') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-10">

                                            <input type="hidden" class="form-control" name="grupo" value="{{$group->id}}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="mr-auto">
                                <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous" value="Previous">
                            </div>
                            <div class="ml-auto">
                                <input type="button" class="btn btn-next btn-fill btn-primary btn-wd" name="next" value="Siguiente">
                                <button type="submit" class="btn btn-finish btn-fill btn-primary btn-wd">
                                    Guardar
                                </button>

                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- wizard container -->
        </div>
    </div>



</div>








@endsection
@push('js')
<script>
    $(document).ready(function() {
        // Initialise the wizard
        demo.initMaterialWizard();
        setTimeout(function() {
            $('.card.card-wizard').addClass('active');
        }, 600);
        $(
            "#create-new-student"
        ).submit(() => {
            $("#modal-spinner").modal("show");
        });



    });
</script>
@endpush