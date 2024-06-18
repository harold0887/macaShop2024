<div class="content py-0 bg-white">

    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb my-0 text-xs lg:text-base">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{route('profile.edit')}}">Cuenta</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('grupos.index') }}">Registro de asistencia</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mis grupos</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-between">


        <div class="col-12 col-md-auto  align-self-md-center ">
            @if(isset($myGroups) && $myGroups->count() > 0)
            <a class="btn btn-primary btn-block " href="{{ route('grupos.create') }}">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="material-icons mr-2">add_circle</i>
                    <span>Nuevo grupo</span>
                </div>
            </a>
            @endif
        </div>
        @if (!auth()->user()->pro)
        <div class="col-12 col-md-auto  align-self-md-center">
            <a class="btn btn-rose w-100" href="{{ route('asistencia.demo') }}" type="button">Upgrade to pro</a>
        </div>
        @endif
    </div>
    <div class="row justify-content-center">
        @if(isset($myGroups) && $myGroups->count() > 0)

        @foreach($myGroups as $group)
        <div class="col-lg-4 cards">
            <div class="card card-pricing card-raised ">
                <div class="card-body">
                    <div style="position: absolute; right:10px">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="material-symbols-outlined">
                                more_vert
                            </span>
                        </a>
                        <div class="dropdown-menu px-0" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('add-student', $group->id) }}">Agregar Alumnos</a>
                            <a class="dropdown-item" href="">Editar Alumnos</a>
                            <a class="dropdown-item" href="{{ route('group-report', $group->id) }}">Reporte PDF</a>
                            <a class="dropdown-item" href="{{ route('group-report-excel', $group->id) }}">Reporte Excel</a>
                            <button type="button" class="dropdown-item">Duplicar</button>
                            <button type="button" class="dropdown-item" wire:click="ocultar('{{$group->id}}')">Ocultar</button>
                            <a class="dropdown-item" href="{{ route('grupos.edit', $group->id) }}">Editar</a>
                            <button type="button" class="dropdown-item" onclick="confirmDelete('{{ $group->id }}', '{{ $group->grado_grupo }}', '{{ $group->escuela }}', '{{ $group->ciclo_escolar}}')">Eliminar</button>
                        </div>
                    </div>

                    <h6 class="card-category">{{$group->grado_grupo}}</h6>
                    <span class="card-category">{{$group->escuela}}</span>
                    <span class="card-category d-block">Ciclo escolar {{$group->ciclo_escolar}}</span>
                    <div class="card-icon icon-{{$group->color}} ">
                        <i class="material-icons " style="position: relative !important;">
                            @php
                            $nombre = $group->escuela;
                            $separadas = explode(" ", $nombre);
                            $corto = "";
                            foreach ($separadas as $primera) {
                            $corto .= substr($primera, 0, 1);
                            }
                            @endphp

                            @if ($group->itemMain)
                            <img class="img-grupo" src="{{ Storage::url($group->itemMain)  }}" alt="..." width="100">
                            @else

                            <span class="text-uppercase" style="font-family: Arial, Helvetica, sans-serif !important;">{{$corto}}</span>
                            @endif





                        </i>
                    </div>
                    <h3 class="card-title">{{$group->estudiantes->count()}} Alumnos
                    </h3>
                    <p class="card-description d-flex justify-content-between">
                        @if($group->materia)
                        <span>Materia: {{$group->materia}}</span>
                        @else
                        <span class="text-white">Materia:</span>
                        @endif
                        @if($group->maestro)
                        <span>Maestra(o): {{$group->maestro}}</span>
                        @endif
                    </p>
                    <a href="{{ route('grupos.show', $group->id) }}" class="btn btn-{{$group->color}} btn-round">Seleccionar</a>
                </div>
            </div>
        </div>


        @endforeach
        @else
        <div class="col-lg-4 cards">
            <div class="card card-pricing card-plain">
                <div class="card-body">
                    <h6 class="card-category">Registra tu primer grupo</h6>
                    <span class="card-category text-white">-</span>
                    <div class="card-icon">
                        <i class="material-icons">school</i>
                    </div>

                    <p class="card-description">
                        Crea un nuevo grupo para poder administrar la asistencia y las evaluaciones de tus alumnos.
                    </p>
                    @if (!auth()->user()->pro)
                    <p class="card-description">
                        Esta es una versión gratuita que permite registrar solo un grupo con máximo 25 alumnos, si necesita registrar más grupos o más de 25 alumnos en el grupo adquiera la versión <b>PRO</b>,
                        <a href="{{ route('asistencia.demo') }}">aquí</a>,
                    </p>
                    @endif
                    <a href="{{ route('grupos.create') }}" class="btn btn-outline-primary btn-round">Nuevo grupo</a>
                </div>
            </div>
        </div>


        @endif

    </div>
    <div class="row">
        <div class="col-12 col-lg-6">
            @if(isset($myGroupsHide) && $myGroupsHide->count() > 0)
            <p class="card-category">
                Grupos ocultos.
            </p>

            <div class="table-responsive">
                <table class="table table-striped my-0">
                    <tbody>
                        @foreach($myGroupsHide as $group)
                        <tr>
                            <td class="py-0">{{ $group->escuela }} - {{ $group->grado_grupo }} </td>
                            <td class="py-0">
                                <button class="btn btn-link my-0 py-0">
                                    <i class="material-icons text-info" wire:click="mostrar('{{$group->id}}')">visibility</i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



            @endif


        </div>
    </div>



</div>
<script>
    //Confirmar eliminar producto
    function confirmDelete($id, grado, escuela, ciclo) {
        Swal.fire({
            title: "¿Realmente quiere eliminar el grupo: " + grado + " - " + escuela + "  ?",
            text: "Se van a eliminar todos los alumnos y sus registros, esto no se puede recuperar.!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar",
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('delete-group', {
                    id: $id
                });
            } else {
                Swal.fire({
                    title: "Cancelado!",
                    text: "Tu grupo está seguro :)",
                    icon: "error"
                });
            }
        });
    }
</script>