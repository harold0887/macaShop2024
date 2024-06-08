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
            <div class="page-categories ">
                <div class="tab-content tab-space tab-subcategories pt-0">
                    <div class="tab-pane active " id="link7">
                        <div class="card my-0 ">
                            <div class="card-body py-0 ">
                                <div class="row">


                                    <div class="col-12 col-md-auto">

                                    </div>
                                    <div class="col-12">
                                        <div class="row justify-content-between">

                                            <div class="col-12 col-md-auto d-flex">
                                                <div class="card-footer p-0">
                                                    <div class="stats ">
                                                        <select class="form-control text-muted" wire:model.live="monthSelect" wire:change="setNames()">
                                                            <option selected value="">Selecciona el mes...</option>
                                                            <option value="01">Enero</option>
                                                            <option value="02">Febrero</option>
                                                            <option value="03">Marzo</option>
                                                            <option value="04">April</option>
                                                            <option value="05">Mayo</option>
                                                            <option value="06">Junio</option>
                                                            <option value="07">Julio</option>
                                                            <option value="08">Agosto</option>
                                                            <option value="09">Septiembre</option>
                                                            <option value="10">Octubre</option>
                                                            <option value="11">Noviembre</option>
                                                            <option value="12">Diciembre</option>
                                                        </select>
                                                        @if( $monthSelect != now()->format('m') )
                                                        <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="clearMonth()">close</i>
                                                        @endif

                                                    </div>
                                                </div>


                                                <div class="card-footer p-0">
                                                    <div class="stats">
                                                        <select class="form-control" name="fop" wire:model.live="yearSelect">
                                                            <option selected value="">Selecciona el año...</option>
                                                            @for ($i = 2023; $i < 2030; $i++) <option value="{{$i}}"> {{$i}} </option>
                                                                @endfor
                                                        </select>

                                                        @if( $yearSelect != now()->format('Y') )
                                                        <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="$set('yearSelect', '{{now()->format('Y')}}')">close</i>
                                                        @endif
                                                    </div>
                                                </div>




                                            </div>


                                            <div class="col-12 col-md-auto p-0  ">
                                                <button class="btn btn-primary btn-link m-0 p-0" wire:click="export()">
                                                    <img src="{{ asset('img') }}/docs/pdf.png" alt="..." width="40">
                                                    Exportar a PDF
                                                </button>
                                            </div>
                                        </div>
                                    </div>


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

                                                        <th colspan="{{$lastDay}}" scope="col">{{$monthSelectName}} {{$yearSelect}}</th>
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
                                                        <td>{{ $estudiante->apellidos }} {{ $estudiante->nombres }}</td>
                                                        <td>

                                                        </td>

                                                        @foreach ($diasMes as $dia)


                                                        @foreach($estudiante->asistencias as $asistencia)
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>