<div class="content py-0 bg-white">
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
                <div class="form-group col-auto py-0">
                    <input type="date" class="form-control fw-bold text-base sm:text-2x1 md:text-2xl  lg:text-2xl text-primary" name="start" wire:model.live="select_date">
                    @error('start')
                    <small class="text-danger"> {{ $message }} </small>
                    @enderror
                </div>
            </div>
        </div>





        <div class="col-md-12 ml-auto mr-auto">
            <div class="page-categories ">
                <div class="tab-content tab-space tab-subcategories pt-0">
                    <div class="tab-pane active " id="link7">
                        <div class="card my-0 ">
                            <div class="card-body py-0">
                                <div class="row justify-content-center">
                                  

                                    <div class="col-12 col-md-6 ">


                                        <div class="accordion accordion-flush text-lg" id="accordionAlumnos">

                                            @foreach($group->estudiantes as $estudiante)
                                            <div class="accordion-item">

                                                <h2 class="accordion-header d-flex " id="flush-headingOne">

                                                    <div class="form-check form-check-inline w-75 ">
                                                        <label class="form-check-label text-base  lg:text-lg" style="padding-left: 35px">
                                                            <input class="form-check-input" type="checkbox" value="" 
                                                            
                                                            @if ($estudiante->asistencias->count() > 0)
                                                            @foreach($estudiante->asistencias as $asistencia)
                                                            @if($asistencia->dia == $select_date)
                                                            checked


                                                            @endif
                                                            @endforeach
                                                           

                                                            @endif
                                                            
                                                            wire:click="saveAssistance({{ $estudiante->id }})"
                                                            > {{$estudiante->apellidos}} {{$estudiante->nombre}}
                                                            <span class="form-check-sign">
                                                                <span class="check" style="width: 30px; height:30px"></span>
                                                            </span>
                                                        </label>
                                                    </div>

                                                    <button class="accordion-button collapsed w-25" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-{{$loop->index}}" aria-expanded="false" aria-controls="flush-{{$loop->index}}">

                                                    </button>
                                                </h2>
                                                <div id="flush-{{$loop->index}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-mdb-parent="#accordionAlumnos">
                                                    <div class="accordion-body">
                                                        <span class="material-symbols-outlined mx-2 text-muted" style="cursor: pointer;">
                                                            sports_soccer
                                                        </span>
                                                        <span class="material-symbols-outlined mx-2 text-muted" style="cursor: pointer;">
                                                            air
                                                        </span>
                                                        <span class="material-symbols-outlined mx-2 text-muted" style="cursor: pointer;">
                                                            biotech
                                                        </span>
                                                        <span class="material-symbols-outlined mx-2 text-muted" style="cursor: pointer;">
                                                            water
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>

                                            @endforeach












                                        </div>




                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>


</div>