<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb my-0 text-xs lg:text-base">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{route('profile.edit')}}">Cuenta</a></li>
                    <li class="breadcrumb-item"><a href="{{route('grupos.index')}}">Mis grupos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$group->escuela}} - {{$group->grado_grupo}} </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row ">
        <div class="col-12 mt-0 mt-lg-0">
            <h2 class=" text-center text-primary text-base sm:text-2x1 md:text-2xl  lg:text-2xl">
                {{$group->escuela}} - {{$group->grado_grupo}}
            </h2>
        </div>
        <div class="col-12">
            <div class="row justify-content-between d-flex align-items-center">
                <div class="col-auto py-0">
                    <span class="text-sm text-muted"><a href="{{ route('grupos.index') }}">Regresar a mis grupos.</a></span>
                </div>
                <div class="col-auto text-muted text-xxs">

                    <span>
                        @if($as->count() > 0)
                        {{$as->count() > 1 ?  $as->count(). ' asistencias'  :  $as->count(). ' asistencia' }},
                        @endif

                    </span>
                    <span>
                        @if($faltas->count() > 0)
                        {{$faltas->count() > 1 ?  $faltas->count(). ' faltas'  :  $faltas->count(). ' falta' }},
                        @endif
                    </span>
                    <span>
                        @if($retardos->count() > 0)
                        {{$retardos->count() > 1 ?  $retardos->count(). ' retardos'  :  $retardos->count(). ' retardo' }},
                        @endif
                    </span>
                    <span>
                        @if($faltasJustificadas->count() > 0)
                        {{$faltasJustificadas->count() > 1 ?  $faltasJustificadas->count(). ' faltas justificadas'  :  $faltasJustificadas->count(). ' falta justificada' }},
                        @endif

                    </span>
                    <span>
                        {{$estudiantes->count() - $as->count() - $faltas->count() -$retardos->count()- $faltasJustificadas->count()}} sin registro.
                    </span>
                </div>

            </div>
        </div>
        <div class="col-md-12 ml-auto mr-auto">
            <div class="page-categories ">
                <div class="tab-content tab-space tab-subcategories pt-0">
                    <div class="tab-pane active " id="link7">
                        <div class="card my-0 ">
                            <div class="card-body py-0">
                                @if(isset($estudiantes) && $estudiantes->count()> 0)
                                <div class="row justify-content-around">




                                    <div class="col-12 col-md-8 ">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">

                                                <input type="date" class="form-control fw-bold text-base sm:text-2x1 md:text-2xl  lg:text-2xl text-primary" name="start" wire:model.live="select_date">
                                                @error('select_date')
                                                <small class="text-danger"> {{ $message }} </small>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="search-panels mt-1">
                                                    <div class="search-group">
                                                        <input required="" type="text" name="text" autocomplete="on" class="input" wire:model.live.debounce.500ms='search' style="height: 36px !important;">
                                                        <label class="enter-label">Buscar por nombre o apellido</label>
                                                        <div class="btn-box">

                                                        </div>
                                                        <div class="btn-box-x">
                                                            <button class="btn-cleare" wire:click="clearSearch()">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                                                                    <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" id="cleare-line"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="accordion accordion-flush text-lg" id="accordionAlumnos">


                                            @foreach($estudiantes as $estudiante)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header d-flex " id="flush-headingOne">
                                                    <div class="d-flex  align-items-center">
                                                        @php
                                                        $exist= false;
                                                        @endphp
                                                        @foreach($asistencias as $asistencia)
                                                        @if($asistencia->estudiante_id == $estudiante->id )
                                                        @php
                                                        $asistencia_select=$asistencia;
                                                        $exist= true;
                                                        @endphp
                                                        @endif
                                                        @endforeach
                                                        @if($exist)

                                                        <button class=" rounded btn btn-asistencia
                                                        @if($asistencia_select->status_id == 1) 

                                                        bg-asistencia 
                                                        @elseif($asistencia_select->status_id == 2 ) 
                                                        bg-falta  
                                                        @elseif($asistencia_select->status_id == 3) 
                                                        bg-retardo 
                                                        @elseif($asistencia_select->status_id == 4) 
                                                        bg-falta-justificada 
                                                        @elseif($asistencia_select->status_id == 5) 
                                                        bg-white
                                                        @else
                                                        bg-white
                                                        @endif " {{ isset($asistencia_select) && $asistencia_select->status_id == 1 ?'disabled':''}} wire:click="asistencia({{ $estudiante->id }})" data-toggle="tooltip" data-placement="top" title="Registrar asistencia">
                                                        </button>

                                                        @else
                                                        <button class="rounded btn btn-asistencia border" wire:click="asistencia({{ $estudiante->id }})" data-toggle="tooltip" data-placement="top" title="Registrar asistencia">
                                                        </button>
                                                        @endif
                                                    </div>



                                                    <button class="accordion-button collapsed  text-base  lg:text-lg text-muted" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-{{$loop->index}}" aria-expanded="false" aria-controls="flush-{{$loop->index}}">
                                                        {{$estudiante->apellidos}} {{$estudiante->nombres}}
                                                    </button>
                                                </h2>
                                                <div id="flush-{{$loop->index}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-mdb-parent="#accordionAlumnos">
                                                    <div class="accordion-body">
                                                        <div class="d-flex  align-items-center">

                                                            @if($exist)
                                                            <button class="btn d-flex align-items-center border text-muted btn-falta " wire:click="falta({{ $estudiante->id }})" {{ isset($asistencia_select) && $asistencia_select->status_id == 2 ?'disabled':''}} data-toggle="tooltip" data-placement="top" title="Registrar falta">
                                                                <span class="fw-bold text-muted">F</span>
                                                            </button>
                                                            <button class="btn d-flex align-items-center border text-muted btn-falta " wire:click="retardo({{ $estudiante->id }})" {{ isset($asistencia_select) && $asistencia_select->status_id == 3 ?'disabled':''}} data-toggle="tooltip" data-placement="top" title="Registrar retardo">
                                                                <span class="fw-bold text-muted">R</span>
                                                            </button>
                                                            <button class="btn d-flex align-items-center border text-muted btn-falta " wire:click="faltaJustificada({{ $estudiante->id }})" {{ isset($asistencia_select) && $asistencia_select->status_id == 4 ?'disabled':''}} data-toggle="tooltip" data-placement="top" title="Registrar falta justificada">
                                                                <span class="fw-bold text-muted">FJ</span>
                                                            </button>
                                                            <button class="btn d-flex align-items-center border text-muted btn-falta " wire:click="sinRegistro({{ $estudiante->id }})" @if(!$exist) disabled @endif {{ isset($asistencia_select) && $asistencia_select->status_id == 5 ?'disabled':''}} data-toggle="tooltip" data-placement="top" title="Eliminar registro">
                                                                <span class="fw-bold text-muted">SR</span>
                                                            </button>

                                                            @else
                                                            <button class="btn d-flex align-items-center border text-muted btn-falta " wire:click="falta({{ $estudiante->id }})"  data-toggle="tooltip" data-placement="top" title="Registrar falta">
                                                                <span class="fw-bold text-muted">F</span>
                                                            </button>
                                                            <button class="btn d-flex align-items-center border text-muted btn-falta " wire:click="retardo({{ $estudiante->id }})"  data-toggle="tooltip" data-placement="top" title="Registrar retardo">
                                                                <span class="fw-bold text-muted">R</span>
                                                            </button>
                                                            <button class="btn d-flex align-items-center border text-muted btn-falta " wire:click="faltaJustificada({{ $estudiante->id }})"  data-toggle="tooltip" data-placement="top" title="Registrar falta justificada">
                                                                <span class="fw-bold text-muted">FJ</span>
                                                            </button>
                                                            <button class="btn d-flex align-items-center border text-muted btn-falta " wire:click="sinRegistro({{ $estudiante->id }})" @if(!$exist) disabled @endif  data-toggle="tooltip" data-placement="top" title="Eliminar registro">
                                                                <span class="fw-bold text-muted">SR</span>
                                                            </button>

                                                            @endif





                                                        </div>
                                                        <div class="d-flex  align-items-center">

                                                            @foreach($tags as $tag)
                                                            @php
                                                            $existTag= false;
                                                            @endphp
                                                            @foreach($estudiante->tags as $tag_es)
                                                            @if($tag_es->tag_id == $tag->id && $tag_es->dia == $select_date)
                                                            @php
                                                            $tag_select=$tag_es->id;
                                                            $existTag= true;
                                                            @endphp
                                                            @endif
                                                            @endforeach

                                                            @if($existTag)
                                                            <button class="btn d-flex align-items-center border" wire:click="deleteTag('{{ $tag_select }}')" {{ isset($asistencia_select) && $asistencia_select->status_id == 2 ?'disabled':''}} {{ isset($asistencia_select) && $asistencia_select->status_id == 4 ?'disabled':''}} @if(!$exist) disabled @endif data-toggle="tooltip" data-placement="top" title="Eliminar {{$tag->name}}">
                                                                <span class="material-symbols-outlined  text-primary">
                                                                    {{$tag->icon}}
                                                                </span>
                                                            </button>

                                                            @else
                                                            <button class="btn d-flex align-items-center border" wire:click="saveTag('{{ $estudiante->id }}','{{$tag->id}}')" {{ isset($asistencia_select) && $asistencia_select->status_id == 2 ?'disabled':''}} {{ isset($asistencia_select) && $asistencia_select->status_id == 4 ?'disabled':''}} @if(!$exist) disabled @endif data-toggle="tooltip" data-placement="top" title="Registrar {{$tag->name}}">
                                                                <span class="material-symbols-outlined  text-muted">
                                                                    {{$tag->icon}}
                                                                </span>
                                                            </button>

                                                            @endif
                                                            @endforeach
                                                        </div>


                                                    </div>

                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col">
                                        <p>No hay alumbos</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>