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

                                            @foreach($estudiantes as $estudiante)
                                            <div class="accordion-item">

                                                <h2 class="accordion-header d-flex " id="flush-headingOne">
                                                    <div class="d-flex  align-items-center">
                                                        <div class="border   rounded 

                                                        @foreach($estudiante->asistencias as $asistencia)
                                                            @if($asistencia->dia == $select_date && $asistencia->asistencia)
                                                            border-success bg-success


                                                            @endif
                                                            @endforeach


                                                        
                                                        " style="width: 30px; height:30px; cursor: pointer" wire:click="saveAssistance({{ $estudiante->id }})">

                                                        </div>


                                                    </div>



                                                    <button class="accordion-button collapsed  text-base  lg:text-lg text-muted" type="button" data-mdb-toggle="collapse" data-mdb-target="#flush-{{$loop->index}}" aria-expanded="false" aria-controls="flush-{{$loop->index}}">
                                                        {{$estudiante->apellidos}} {{$estudiante->nombre}}
                                                    </button>
                                                </h2>
                                                <div id="flush-{{$loop->index}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-mdb-parent="#accordionAlumnos">
                                                    <div class="accordion-body">

                                                        @foreach($tags as $tag)
                                                        @php
                                                        $exist= false;
                                                        @endphp
                                                        @foreach($estudiante->tags as $tag_es)
                                                        @if($tag_es->tag_id == $tag->id )
                                                        @php
                                                        $exist= true;
                                                        @endphp
                                                        @endif
                                                        @endforeach

                                                        @if($exist)
                                                        <span class="material-symbols-outlined mx-2 text-primary" style="cursor: pointer;" wire:click="saveTag('{{ $estudiante->id }}','{{$tag->id}}')">
                                                            {{$tag->icon}}
                                                        </span>
                                                        @else
                                                        <span class="material-symbols-outlined mx-2 text-muted" style="cursor: pointer;" wire:click="saveTag('{{ $estudiante->id }}','{{$tag->id}}')">
                                                            {{$tag->icon}}
                                                        </span>
                                                        @endif
                                                        @endforeach


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