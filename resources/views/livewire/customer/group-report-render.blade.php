<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')
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
                            <div class="card-body py-0 border border-danger">
                                <div class="row">

                                    <div class="col-12 border">reporte {{$monthSelect}} - {{$yearSelect}} - {{$firstDay}} - {{$lastDay}} </div>
                                    <div class="col-12 col-md-auto">
                                        <select class="form-control text-muted" wire:model.live="monthSelect">
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
                                    <div class="col-12 col-md-auto">
                                        <div class="stats">
                                            <select class="form-control" name="fop" wire:model.live="yearSelect">
                                                <option selected value="">Selecciona el año...</option>
                                                @for ($i = 2020; $i < 2030; $i++) <option value="{{$i}}"> {{$i}} </option>
                                                    @endfor
                                            </select>

                                            @if( $yearSelect != now()->format('Y') )
                                            <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="$set('yearSelect', '{{now()->format('Y')}}')">close</i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-auto">
                                        <a class="nav-link d-flex align-items-center" href="{{ route('group-report-pdf','1') }}" target="_blank">
                                            <i class="material-icons ml-1">checklist</i>
                                            Exportr a PDF
                                        </a>
                                    </div>
                                    <div class="col-12">
                                        <form id="create-product-admin" action="{{ route('group-reports-pdf','1') }}"  method="POST">
                                            @csrf

                                            <button  class="btn btn-link btn-primary">
                                            <i class="material-icons ml-1">checklist</i>
                                            Exportr a PDF
                                            </button>

                                        </form>

                                    </div>

                                    <div class="col-12">
                                        <div class="table-responsive ">
                                            <table class=" table  table-striped">

                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" scope="col"></th>
                                                        <th colspan="{{$lastDay}}" class="text-center" scope="col">{{$monthSelectName}} {{$yearSelect}}</th>
                                                    </tr>


                                                    <tr class="text-center">
                                                        @foreach ($diasMes as $dia)
                                                        <td>


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



                                                            <span class="d-block">{{date_format(new DateTime($dia),'d')}}</span>
                                                        </td>
                                                        @endforeach

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($estudiantes as $estudiante)
                                                    <tr>
                                                        <td>{{ $estudiante->apellidos }} {{ $estudiante->nombres }}</td>

                                                        @foreach ($diasMes as $dia)


                                                        @php
                                                        $exist= false;
                                                        @endphp
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
                                                            <span class="text-asistencia">
                                                                A
                                                            </span>
                                                            @elseif($asistencia_select->status_id == 2 )
                                                            <span class="text-falta">
                                                                F
                                                            </span>
                                                            @elseif($asistencia_select->status_id == 3)
                                                            <span class="text-retardo">
                                                                R
                                                            </span>
                                                            @elseif($asistencia_select->status_id == 4)
                                                            <span class="text-falta-justificada">
                                                                FJ
                                                            </span>
                                                            @elseif($asistencia_select->status_id == 5)
                                                            <span class="text-white">
                                                                -
                                                            </span>

                                                            @endif
                                                        </td>
                                                        @else
                                                        <td class="text-center">
                                                            -
                                                        </td>
                                                        @endif
                                                        @endforeach
                                                    </tr>
                                                    @endforeach
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