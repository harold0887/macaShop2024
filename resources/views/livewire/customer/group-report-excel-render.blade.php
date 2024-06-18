<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')
    @php
    $exist= false;
    $a=0;
    $f=0;
    $fj=0;
    $r=0
    @endphp
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb my-0 text-xs lg:text-base">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{route('profile.edit')}}">Cuenta</a></li>
                    <li class="breadcrumb-item"><a href="{{route('grupos.index')}}">Mis grupos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$group->grado_grupo}} - {{$group->escuela}} </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row ">
        <div class="col-12 mt-0 mt-lg-0">
            <h2 class=" text-center text-primary text-base sm:text-2x1 md:text-2xl  lg:text-2xl">
                {{$group->grado_grupo}} - {{$group->escuela}}
            </h2>
        </div>
        <div class="col-12">
            <div class="row justify-content-between d-flex align-items-center">
                <div class="col-auto py-0">
                    <span class="text-sm text-muted"><a href="{{ route('grupos.index') }}">Regresar a mis grupos.</a></span>
                </div>


            </div>
        </div>
        <div class="col-md-12 ml-auto mr-auto">
            @dump($filters)
            <div class="col-12">
                @dump($asistencias)
            </div>
            <div class="col-12">
                @dump($estudiantes)
            </div>
            <div class="col-12">
                @dump($estudiante1)

            </div>
            <div class="page-categories ">
                <div class="tab-content tab-space tab-subcategories pt-0">
                    <div class="tab-pane active " id="link7">
                        <div class="card my-0 ">
                            <div class="card-body py-0 ">
                                @if(isset($estudiantes) && $estudiantes->count()> 0)



                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="text-lg fw-bold text-muted">Generar reportes Excel</h4>
                                        <div>
                                            <div class="row">
                                                <label class="col-auto col-form-label">Desde el:</label>
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <input type="date" class="form-control" wire:model.live="filters.fromDate">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label class="col-auto col-form-label">Hasta el:</label>
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <input type="date" class="form-control" wire:model.live="filters.toDate">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive ">
                                            <table class=" table  table-striped">

                                                <thead>
                                                    <tr>
                                                        <th rowspan="3" scope="col">
                                                            <img src="https://materialdidacticomaca.com/img/logo3.png" alt="..." width="100">
                                                        </th>
                                                        <th rowspan="3">

                                                        </th>

                                                        <th colspan="{{$lastDay}}" scope="col">Nombre del rango</th>
                                                    </tr>
                                                    <tr class="text-center">
                                                        @foreach ($diasMes as $dia)
                                                        <th>


                                                            @if(date_format(new DateTime($dia),'l')=='Monday')
                                                            L
                                                            @elseif(date_format(new DateTime($dia),'l')=='Tuesday')
                                                            M
                                                            @elseif(date_format(new DateTime($dia),'l')=='Wednesday')
                                                            M
                                                            @elseif(date_format(new DateTime($dia),'l')=='Thursday')
                                                            J
                                                            @elseif(date_format(new DateTime($dia),'l')=='Friday')
                                                            V
                                                            @elseif(date_format(new DateTime($dia),'l')=='Saturday')
                                                            S
                                                            @elseif(date_format(new DateTime($dia),'l')=='Sunday')
                                                            D
                                                            @endif




                                                        </th>
                                                        @if(date_format(new DateTime($dia),'l')=='Friday' || $loop->last)
                                                        <th>

                                                        </th>

                                                        @endif

                                                        @endforeach
                                                        <td class="text-center">
                                                            <span>A</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span>F</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span>FJ</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span>R</span>
                                                        </td>

                                                    </tr>


                                                    <tr class="text-center">
                                                        @foreach ($diasMes as $dia)
                                                        <th>




                                                            <span class="d-block">{{date_format(new DateTime($dia),'d')}}</span>
                                                        </th>
                                                        @if(date_format(new DateTime($dia),'l')=='Friday' || $loop->last)
                                                        <th>

                                                        </th>

                                                        @endif

                                                        @endforeach


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($estudiantes) && $estudiantes->count() > 0)
                                                    @foreach ($estudiantes as $estudiante)

                                                    <tr>

                                                        <td>{{$loop->iteration}}.- {{ $estudiante->apellidos }} {{ $estudiante->nombres }}</td>
                                                        <td>

                                                        </td>

                                                        @foreach ($diasMes as $dia)


                                                        @foreach($asistencias as $asistencia)
                                                        @if(date_format(new DateTime($asistencia->dia),'Y-m-d') == $dia->format('Y-m-d') && $asistencia->estudiante_id ==$estudiante->id )
                                                        @php
                                                        $asistencia_select=$asistencia;
                                                        $exist= true;
                                                        @endphp


                                                        @endif
                                                        @endforeach
                                                        @if($exist)
                                                        <td class="text-center border">

                                                            @if($asistencia_select->status_id == 1)
                                                            @php
                                                            $a=$a+1;
                                                            @endphp

                                                            <span class="material-symbols-outlined text-lg text-muted">
                                                                check_box
                                                            </span>
                                                            @elseif($asistencia_select->status_id == 2 )
                                                            @php
                                                            $f=$f+1;
                                                            @endphp
                                                            <span class="text-falta">
                                                                F
                                                            </span>
                                                            @elseif($asistencia_select->status_id == 3)
                                                            @php
                                                            $r=$r+1;
                                                            @endphp
                                                            <span class="text-retardo">
                                                                R
                                                            </span>
                                                            @elseif($asistencia_select->status_id == 4)
                                                            @php
                                                            $fj=$fj+1;
                                                            @endphp
                                                            <span class="text-falta-justificada">
                                                                FJ
                                                            </span>
                                                            @elseif($asistencia_select->status_id == 5)
                                                            <span>
                                                                -
                                                            </span>

                                                            @endif
                                                        </td>

                                                        @if(date_format(new DateTime($dia),'l')=='Friday' || $loop->last)
                                                        <td class="px-8">

                                                        </td>


                                                        @endif
                                                        <!-- clear exist -->
                                                        @php
                                                        $exist= false;
                                                        @endphp


                                                        @else
                                                        <td class="text-center">
                                                            -
                                                        </td>
                                                        @if(date_format(new DateTime($dia),'l')=='Friday' || $loop->last)
                                                        <td class="px-8">

                                                        </td>

                                                        @endif
                                                        @endif
                                                        @endforeach
                                                        <td class="text-center border px-8">{{$a}}</td>
                                                        <td class="text-center border px-8">{{$f}}</td>
                                                        <td class="text-center border px-8">{{$fj}}</td>
                                                        <td class="text-center border px-8">{{$r}}</td>
                                                        @php
                                                        $a=0;
                                                        $f=0;
                                                        $fj=0;
                                                        $r=0
                                                        @endphp
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row mb-5">
                                    <div class="col-12 mt-5 text-center">
                                        <span class="h4 text-muted">Este grupo aún no tiene alumnos registrados, empecemos con agregar un alumno. <span>
                                    </div>
                                    <div class="col-12 text-center mt-5">
                                        <a href="{{ route('add-student', $group->id) }}" class="text-white btn btn-primary btn-lg btn-round">
                                            <div class="d-flex align-items-center">
                                                <i class="material-icons  mr-2 ">add</i>
                                                <span class="fw-bold">Agregar Alumnos</span>
                                            </div>
                                        </a>
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