<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .text-asistencia {
            color: rgb(174, 76, 170) !important;
        }

        .text-falta {
            color: rgb(235, 104, 100) !important;
        }

        .text-retardo {
            color: rgb(245, 230, 37) !important;
        }

        .text-falta-justificada {
            color: rgb(245, 122, 0) !important;
        }
    </style>








</head>

<body>

    <div class="col-12">
        <div class="table-responsive ">
            <table class=" table  table-striped">

                <thead>
                    <tr>
                        <th rowspan="2" scope="col"></th>
                        <th colspan="{{$lastDay}}" class="text-center" scope="col">Nombre del mes 2024</th>
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

</body>

</html>