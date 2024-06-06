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
    <div class="row justify-content-center">
        @if(isset($myGroups) && $myGroups->count() > 0)

        @foreach($myGroups as $group)
        <div class="col-lg-4 cards">
            <div class="card card-pricing card-raised">
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
                            <a class="dropdown-item" href="{{ route('group-report', $group->id) }}">Reportes</a>
                            <button type="button" class="dropdown-item">Duplicar</button>
                            <button type="button" class="dropdown-item" wire:click="ocultar('{{$group->id}}')">Ocultar</button>
                            <a class="dropdown-item" href="{{ route('grupos.edit', $group->id) }}">Editar</a>
                            <button type="button" class="dropdown-item" onclick="confirmDelete('{{ $group->id }}', '{{ $groupTest->grado_grupo }}', '{{ $groupTest->escuela }}', '{{ $groupTest->ciclo_escolar}}')">Eliminar</button>
                        </div>
                    </div>

                    <h6 class="card-category">{{$group->escuela}}</h6>
                    <span class="card-category">{{$group->grado_grupo}} - Ciclo escolar {{$group->ciclo_escolar}}</span>
                    <div class="card-icon icon-{{$group->color}} ">
                        <i class="material-icons ">
                            @php
                            $nombre = $group->escuela;
                            $separadas = explode(" ", $nombre);
                            $corto = "";
                            foreach ($separadas as $primera) {
                            $corto .= substr($primera, 0, 1);
                            }
                            @endphp
                            <span class="text-uppercase">{{$corto}}</span>
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
            <div class="card card-pricing card-raised">
                <div class="card-body">
                    <div style="position: absolute; right:10px">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="material-symbols-outlined">
                                more_vert
                            </span>
                        </a>
                        <div class="dropdown-menu px-0" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('add-student', $groupTest->id) }}">Agregar Alumnos</a>
                            <a class="dropdown-item" href="">Editar Alumnos</a>
                            <a class="dropdown-item" href="{{ route('group-report', $groupTest->id) }}">Reportes</a>
                            <button type="button" class="dropdown-item" wire:click="ocultar('{{$groupTest->id}}')">Ocultar grupo</button>
                            <a class="dropdown-item" href="{{ route('grupos.edit', $groupTest->id) }}">Editar grupo</a>
                            <button type="button" class="dropdown-item" onclick="confirmDelete('{{ $groupTest->id }}', '{{ $groupTest->grado_grupo }}', '{{ $groupTest->escuela }}', '{{ $groupTest->ciclo_escolar}}')">Eliminar grupo</button>
                        </div>
                    </div>

                    <h6 class="card-category">{{$groupTest->escuela}} (grupo de ejemplo) </h6>
                    <span class="card-category">{{$groupTest->grado_grupo}} - Ciclo escolar {{$groupTest->ciclo_escolar}}</span>
                    <div class="card-icon icon-{{$groupTest->color}} ">
                        <i class="material-icons ">
                            @php
                            $nombre = $groupTest->escuela;
                            $separadas = explode(" ", $nombre);
                            $corto = "";
                            foreach ($separadas as $primera) {
                            $corto .= substr($primera, 0, 1);
                            }
                            @endphp
                            {{$corto}}
                        </i>
                    </div>
                    <h3 class="card-title">{{$groupTest->estudiantes->count()}} Alumnos</h3>
                    <p class="card-description d-flex justify-content-between">
                        @if($groupTest->materia)
                        <span>Materia: {{$groupTest->materia}}</span>
                        @else
                        <span class="text-white">Materia:</span>
                        @endif
                        @if($groupTest->maestro)
                        <span>Maestra(o): {{$groupTest->maestro}}</span>
                        @endif
                    </p>
                    <a href="{{ route('grupos.show', $groupTest->id) }}" class="btn btn-{{$groupTest->color}} btn-round">Seleccionar</a>
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-4 cards">
            <div class="card card-pricing card-plain">
                <div class="card-body">
                    <h6 class="card-category">Crear nuevo Grupo</h6>
                    <span class="card-category text-white">-</span>
                    <div class="card-icon">
                        <i class="material-icons">domain_add</i>
                    </div>
                    <h3 class="card-title">FREE</h3>
                    <p class="card-description">
                        Crea un nuevo grupo para poder administrar la asistencia de tus alumnos.
                    </p>
                    <a href="{{ route('grupos.create') }}" class="btn btn-white btn-round">Choose Plan</a>
                </div>
            </div>
        </div>
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
        var text =
            "<span class='font-weight-bold'>Realmente quiere eliminar el grupo</span>" +
            "<span> <br><br> " +
            grado + " - " + ciclo + " - " + escuela +
            "</span><br><br>" +
            "<span class='font-italic text-sm'> Se van a eliminar todos los alumnos del grupo y sus registros, esta accion no se puede revertir.</span>";
        swal({
            //title: "¿Realmente quiere eliminar el grupo: " + $name + "  ?. Se van a eliminar todos los alumnos y sus registros, esto no se puede recuperar.",
            html: text,
            type: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!",
        }).then((result) => {
            if (result.value) {
                Livewire.dispatch('delete-group', {
                    id: $id
                });
            } else {
                Swal('Cancelado', 'Tu grupo está seguro :)');
            }
        });
    }
</script>