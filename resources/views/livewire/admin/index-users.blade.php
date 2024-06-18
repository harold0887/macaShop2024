<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0">
                                <h4 class="card-title font-weight-bold">Usuarios ({{$users->total()}} registros)</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12">
                            <div class="row justify-content-between">
                                <div class="col-12 col-md-8   align-self-md-center">
                                    <div class="search-panels">
                                        <div class="search-group">
                                            <input required="" type="text" name="text" autocomplete="on" class="input" wire:model.live.debounce.500ms='search'>
                                            <label class="enter-label">Buscar por nombre, email, WhatsApp, facebook</label>
                                            <div class="btn-box">

                                            </div>
                                            <div class="btn-box-x">
                                                <button class="btn-cleare" wire:click="clearSearch()">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                                                        <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" id="cleare-line"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            @if ($search != '')
                            <small class="text-primary">{{ $users->count() }} resultados obtenidos</small>

                            @endif
                        </div>
                        @if (isset($users) && $users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="cursor:pointer" wire:click="setSort('id')">
                                            @if($sortField=='id')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            ID
                                        </th>

                                        <th style="cursor:pointer" wire:click="setSort('name')">
                                            @if($sortField=='name')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Nombre
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('email')">

                                            @if($sortField=='email')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Correo electronico
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('created_at')">
                                            @if($sortField=='created_at')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Registro
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('email_verified_at')">

                                            @if($sortField=='email_verified_at')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Verified
                                        </th>

                                        <th style="cursor:pointer" wire:click="setSort('whatsapp')">
                                            @if($sortField=='whatsapp')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            WhatsApp
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('facebook')">
                                            @if($sortField=='facebook')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Facebook
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('sales_count')">
                                            @if($sortField=='sales_count')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Ventas
                                        </th>
                                        <th style="cursor:pointer">
                                            Membresías
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('roles_count')">
                                            @if($sortField=='roles_count')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Rol
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('ips_count')">
                                            @if($sortField=='ips_count')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            IP
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('status')">
                                            @if($sortField=='status')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Status
                                        </th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr class=" {{ $user->status == 0 ? 'table-danger ' : '' }}">
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{date_format($user->created_at, 'd-M-y')}}</td>
                                        <td class="text-center">
                                            @if($user->email_verified_at != null)
                                            <i class="material-icons text-success">check_circle</i>
                                            @endif


                                        </td>

                                        <td>{{$user->whatsapp}}</td>
                                        <td>{{$user->facebook}}</td>
                                        <td>
                                            {{$user->sales_count}}
                                        </td>
                                        <td>
                                            @foreach($user->orders as $order)
                                            @if($order->status=='approved')
                                            @foreach($order->memberships as $memberships)
                                            <span class="badge badge-info d-block my-1">
                                                {{$memberships->title}}
                                            </span>
                                            @endforeach
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($user->roles as $role)

                                            <span class="badge badge-info  d-block my-1">
                                                {{ $role->name }}
                                            </span>

                                            @endforeach


                                        </td>
                                        <td>{{$user->ips->count()}}</td>


                                        <td>

                                            <div class="togglebutton" wire:change="changeStatus({{ $user->id }}, '{{ $user->status }}')">
                                                <label>
                                                    <input type="checkbox" {{ $user->status == 1 ? 'checked ' : '' }} name="status">
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>



                                        </td>
                                        <td class="td-actions">
                                            <div class="btn-group shadow-none">
                                                <a class="btn btn-info  btn-link" href="{{ route('users.show', $user->id) }}">
                                                    <i class="material-icons text-info">visibility</i>
                                                </a>
                                                <a class="btn btn-success btn-link" href="{{ route('users.edit', $user->id) }}">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <form id="create-sales-admin" method="POST" action="{{ route('orderp.create',$user->id) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-info btn-link">
                                                        <i class="material-icons">add</i>
                                                    </button>
                                                </form>
                                                <a class="btn btn-success btn-link text-danger " onclick="confirmDeleteUser('{{ $user->id }}', '{{ $user->email }}')">
                                                    <i class="material-icons ">close</i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            {{ $users->links() }}
                        </div>
                        @else
                        <div class="col-12">
                            <p class="alert alert-warning">⚠️ ¡Ooooups! No se encontraron resultados.</p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            <script>
                //Confirmar eliminar producto
                function confirmDeleteUser(id, name) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Realmente desea eliminar a: " + name,
                        text: "No podrás revertir esto.!",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, eliminar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('deleteUser', {
                                id: id
                            });
                        } else {
                            Swal.fire({
                                title: "Cancelado!",
                                text: "El usuario está seguro :)",
                                icon: "error"
                            });
                        }
                    });
                }
            </script>


            @push('js')

            <script>
                $(function() {
                    //activar modal al enviar, se cierra al retornar controlador
                    $(
                        "#create-sales-admin"
                    ).submit(() => {
                        $("#modal-spinner").modal("show");
                    });
                });
            </script>
            @endpush

        </div>
    </div>
</div>