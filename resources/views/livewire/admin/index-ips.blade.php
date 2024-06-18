<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">circles_ext</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h4 class="card-title font-weight-bold">IPS ({{$ips->total()}} registros).</h4>
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
                                            <label class="enter-label">uascar por nombre, email, ip o id</label>
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
                            <small class="text-primary">{{ $ips->count() }} resultados obtenidos</small>

                            @endif
                        </div>
                        <div class="col-12">
                            <small class="text-muted">{{ $lock->count() }} ips bloqueadas, </small>
                        </div>
                        @if (isset($ips) && $ips->count() > 0)
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

                                        <th style="cursor:pointer" wire:click="setSort('ip')">
                                            @if($sortField=='ip')
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
                                        <th style="cursor:pointer">
                                            user id
                                        </th>

                                        <th style="cursor:pointer">
                                            Nombre
                                        </th>
                                        <th style="cursor:pointer">
                                            Email
                                        </th>

                                        <th style="cursor:pointer">
                                            Fecha
                                        </th>
                                        <th style="cursor:pointer">
                                            Status User
                                        </th>
                                        <th style="cursor:pointer">
                                            Status IP
                                        </th>
                                        <th style="cursor:pointer">
                                            Acciones </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ips as $ip)
                                    <tr>
                                        <td>{{ $ip->id }}</td>
                                        <td>{{ $ip->ip }}</td>
                                        <td>{{ $ip->user->id }}</td>
                                        <td>{{ $ip->user->name }}</td>
                                        <td>{{ $ip->user->email }}</td>

                                        <td>{{date_format($ip->created_at, 'd-M-Y h:m')}}</td>
                                        <td>
                                            <div class="togglebutton" wire:change="changeStatus({{ $ip->user->id }}, '{{ $ip->user->status }}')">
                                                <label>
                                                    <input type="checkbox" {{ $ip->user->status == 1 ? 'checked ' : '' }}>
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>


                                        </td>
                                        <td>
                                            @php
                                            $exist=0
                                            @endphp

                                            @foreach($lock as $iplock)

                                            @if($iplock->ip == $ip->ip)
                                            @php
                                            $exist=$exist+1
                                            @endphp
                                            @endif
                                            @endforeach



                                            @if($exist >0)
                                            <button class="btn p-1 btn-outline-danger  p-0 w-100" wire:click="UnBannedIP('{{ $ip->ip }}')">
                                                <i class="material-icons">close</i>
                                                desbloquear
                                            </button>

                                            @else
                                            <button type="submit" class="btn p-1  btn-outline-success p-0  w-100" wire:click="bannedIP('{{ $ip->ip }}')">
                                                <i class="material-icons">add</i>
                                                Bloquear
                                            </button>

                                            @endif





                                        </td>
                                        <td class="td-actions text-center">

                                            <a class="btn btn-success btn-link text-danger " onclick="confirmDeleteIP('{{ $ip->id }}', '{{ $ip->ip }}')">
                                                <i class="material-icons ">close</i>
                                            </a>
                                        </td>





                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            {{ $ips->links() }}
                        </div>
                        @else
                        <div class="col-12">
                            <p class="alert alert-warning">⚠️ ¡Ooooups! No se encontraron resultados.</p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        //Confirmar eliminar producto
        function confirmDeleteIP(id, $name) {
            event.preventDefault();
            Swal.fire({
                title: "Realmente desea eliminar la IP: " + $name,
                text: "No podrás revertir esto.!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar",
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteIP', {
                        id: id
                    });
                } else {
                    Swal.fire({
                        title: "Cancelado!",
                        text: "La IP está segura :)",
                        icon: "error"
                    });
                }
            });
        }
    </script>
</div>