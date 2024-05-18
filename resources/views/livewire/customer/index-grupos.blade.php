<div class="content py-0 bg-white">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb my-0 text-xs lg:text-base">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{route('profile.edit')}}">Cuenta</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Mis grupos</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="page-categories">
                <ul class="nav nav-pills nav-pills-primary nav-pills-icons justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#link7" role="tablist">
                            <i class="material-icons">info</i> Pase de Lista
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#link8" role="tablist">
                            <i class="material-icons">location_on</i> Evaluaciones
                        </a>
                    </li>
                </ul>
                <div class="tab-content tab-space tab-subcategories  py-0">
                    <div class="tab-pane active " id="link7">
                        <div class="card my-0 ">
                            <div class="card-header">

                                <p class="card-category">
                                    Selecciona un grupo para continuar.
                                </p>
                            </div>
                            <div class="card-body pb-0">

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
                                                        <button type="button" class="dropdown-item">Reportes</button>
                                                        <button type="button" class="dropdown-item">Duplicar</button>
                                                        <button type="button" class="dropdown-item" wire:click="ocultar('{{$group->id}}')">Ocultar</button>
                                                        <button type="button" class="dropdown-item">Editar</button>
                                                        <button type="button" class="dropdown-item">Eliminar</button>
                                                    </div>
                                                </div>

                                                <h6 class="card-category">{{$group->escuela}}</h6>
                                                <span class="card-category">{{$group->grado_grupo}} - Ciclo escolar {{$group->cliclo_escolar}}</span>
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
                                                        <!-- <a class="dropdown-item" href="">Reportes</a>
                                                        <a class="dropdown-item" href="">Duplicar</a>
                                                        <a class="dropdown-item" href="">Ocultar</a>
                                                        <a class="dropdown-item" href="">Editar</a>
                                                        <a class="dropdown-item" href="">Eliminar</a> -->
                                                        <button type="button" class="dropdown-item">Eliminar</button>
                                                    </div>
                                                </div>

                                                <h6 class="card-category">{{$groupTest->escuela}} (grupo de ejemplo) </h6>
                                                <span class="card-category">{{$groupTest->grado_grupo}} - Ciclo escolar {{$groupTest->cliclo_escolar}}</span>
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
                                                <a href="#pablo" class="btn btn-{{$groupTest->color}} btn-round">Seleccionar</a>
                                            </div>
                                        </div>
                                    </div>

                                    @endif
                                    <div class="col-lg-4 cards">
                                        <div class="card card-pricing card-plain">
                                            <div class="card-body">
                                                <h6 class="card-category">Crear nuevo Grupo</h6>
                                                <div class="card-icon">
                                                    <i class="material-icons">domain_add</i>
                                                </div>
                                                <h3 class="card-title">FREE</h3>
                                                <p class="card-description">
                                                    This is good if your company size is between 2 and 10 Persons.
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
                        </div>
                    </div>
                    <div class="tab-pane " id="link8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Location of the product</h4>
                                <p class="card-category">
                                    More information here
                                </p>
                            </div>
                            <div class="card-body">
                                Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                                <br>
                                <br> Dramatically maintain clicks-and-mortar solutions without functional solutions.
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


</div>