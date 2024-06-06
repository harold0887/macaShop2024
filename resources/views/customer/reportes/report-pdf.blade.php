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
            color: #FCC552 !important;
        }

        .text-falta-justificada {
            color: rgb(245, 122, 0) !important;
        }

        .accent-white {
            accent-color: white !important;
        }

        .text-center {
            text-align: center !important;
        }




        table {
            border: 1px solid a;
            border-collapse: collapse;
            font-size: 0.70rem;
            line-height: 1rem;
            font-family: Canva Sans, Noto Sans Variable, Noto Sans, -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica, Arial, sans-serif;
        }



        .text-xxs {
            font-size: 0.70rem;
            line-height: 1rem;
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .px-8 {
            padding-left: 8px !important;
            padding-right: 8px !important;
        }

        .table-striped>tbody>tr:nth-of-type(2n+1) {
            background-color: #f9f9f9;
        }

        .UfC7CA {
            background-image: url(http://127.0.0.1:8000/storage/profile/NUfpc85JIxrgOLt3PRpONRTv1DIXfedeEdGM2E35.png);
            background-size: 100% 100%;
            padding-bottom: 16.67%;
            width: 100%;
        }
    </style>








</head>

<body>
    @php
    $exist= false;
    $a=0;
    $f=0;
    $fj=0;
    $r=0
    @endphp



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

                    <input id="c4" class="accent-white" type="checkbox" name="remember" checked>
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

</body>

</html>