<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')
    <div class="row ">
        <div class="col-md-4">
            <div class="row">
                <div class="col-12">
                    <div class="card card-profile {{$user->status == 0 ?'border border-danger': ''}} ">
                        <div class="card-avatar">
                            @if(isset($user->picture))
                            <img class="avatar border-gray" src="{{ Storage::url($user->picture) }}" alt="...">
                            @else
                            <img src="{{ asset('material') }}/img/placeholder.jpg" alt="...">
                            @endif
                        </div>
                        <div class="card-body text-start">
                            <div class="d-flex align-items-center justify-content-center">
                                <h6 class="card-category text-gray d-inline">{{$user->name}}</h6>
                                <a class="btn btn-info btn-link d-inline" href="{{ route('users.edit', $user->id) }}" target="_blank">
                                    <i class="material-icons">edit</i>
                                </a>
                            </div>

                            <p class="card-description text-center my-4 text-sm  lg:text-base d-flex">
                                <span class="fw-bold fst-italic mr-1">Email:</span> <span class=" fst-italic">{{$user->email}}</span>

                            </p>
                            <p class="card-description text-center my-4 text-sm  lg:text-base d-flex">
                                <span class="fw-bold fst-italic mr-1">Status email:</span>
                                @if($user->email_verified_at != null)
                                <span class=" fst-italic">
                                    Verificado
                                </span>
                                <i class="material-icons text-success ml-1">check_circle</i>
                                @else
                                <span class=" fst-italic">
                                    No Verificado
                                </span>
                                <i class="material-icons text-warning ml-1">pending</i>
                                @endif
                            </p>
                            <p class="card-description text-center my-4 text-sm  lg:text-base d-flex">
                                <span class="fw-bold fst-italic mr-1">Registro:</span> <span class=" fst-italic">{{date_format($user->created_at, 'd-M-y')}}</span>
                            </p>



                            <p class="card-description text-center my-4 text-sm  lg:text-base d-flex">
                                <span class="fw-bold fst-italic mr-1">Facebook:</span> <span class=" fst-italic">{{$user->facebook}}</span>
                            </p>
                            <p class="card-description text-center my-4 text-sm  lg:text-base d-flex">
                                <span class="fw-bold fst-italic mr-1">WhatsApp:</span> <span class=" fst-italic">{{$user->whatsapp}}</span>
                            </p>
                            <p class="card-description text-center my-4 text-sm  lg:text-base d-flex">
                                <span class="fw-bold fst-italic mr-1">Comentarios:</span> <span class=" fst-italic">{{$user->comment}}</span>
                            </p>
                            <p class="card-description text-center my-4 text-sm  lg:text-base  d-inline">
                                <span class="fw-bold fst-italic mr-1 d-inline">Status:</span>
                            <div class="togglebutton  d-inline " wire:change="changeStatus({{ $user->id }}, '{{ $user->status }}')">
                                <label>
                                    <input type="checkbox" {{ $user->status == 1 ? 'checked ' : '' }}>
                                    <span class="toggle mb-2 mx-0 {{$user->status == 1?'bg-success':'bg-danger'}}"></span>
                                </label>
                            </div>
                            </p>
                            @if($user->email_verified_at == null)
                            <p class="card-description text-center my-4 text-sm  lg:text-base">
                                El correo electrónico del usuario no ha sido verificado.
                            </p>
                            <p class="card-description text-center my-4 text-sm  lg:text-base  d-inline">
                                <span class="fw-bold fst-italic mr-1 d-inline">Verified_at:</span>
                            <div class="togglebutton  d-inline " onclick="confirmActive('{{ $user->id }}', '{{ $user->email }}')">
                                <label>
                                    <input type="checkbox" {{ $user->email_verified_at != null ? 'checked ' : '' }}>
                                    <span class="toggle mb-2 mx-0 "></span>
                                </label>
                            </div>
                            </p>

                            @endif



                        </div>
                    </div>
                </div>


            </div>

        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header card-header-icon card-header-primary">
                            <div class="card-icon">
                                <i class="material-icons">receiptv</i>
                            </div>
                            <h4 class="card-title">
                                {{$user->orders->count()}} {{$user->orders->count() ==1 ? 'compra':'compras'}}
                            </h4>
                        </div>
                        <div class="card-body">
                            @if($user->orders->count() > 0)
                            <div class="table-responsive ">
                                <table class="table table-striped text-xs">
                                    <thead>
                                        <tr>
                                            <th style="cursor:pointer">
                                                Id
                                            </th>
                                            <th style="cursor:pointer">
                                                Id MP
                                            </th>
                                            <th style="cursor:pointer">
                                                Fecha
                                            </th>
                                            <th style="cursor:pointer">
                                                Cantidad
                                            </th>
                                            <th style="cursor:pointer">
                                                Pago
                                            </th>
                                            <th style="cursor:pointer">
                                                Status
                                            </th>
                                            <th>
                                                Membresía
                                            </th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->payment_id }}</td>
                                            <td>{{date_format($order->created_at, 'd-M-Y g:i a')}}</td>
                                            <td>{{ $order->amount }}</td>
                                            <td>{{ $order->payment_type }}</td>
                                            <td>
                                                @if($order->status == 'create')
                                                <div class="d-flex align-items-center text-muted">
                                                    <i class="material-icons mr-1">pending_actions</i>Pendiente de pago
                                                </div>
                                                @elseif ($order->status == 'approved')
                                                <div class="d-flex align-items-center text-success">
                                                    <i class="material-icons mr-1">check_circle</i>Aprobado
                                                </div>
                                                @elseif($order->status == 'pending')
                                                <div class="d-flex align-items-center text-muted">
                                                    <i class="material-icons mr-1">pending</i>Deposito pendiente
                                                </div>
                                                @elseif($order->status == 'in_process')
                                                <div class="d-flex align-items-center text-muted">
                                                    <i class="material-icons mr-1">watch_later</i>En proceso.
                                                </div>
                                                @elseif($order->status == 'cancelled')
                                                <div class="d-flex align-items-center text-danger">
                                                    <i class="material-icons mr-1">cancel_presentation</i>Cancelado
                                                </div>
                                                @elseif($order->status == 'rejected')
                                                <div class="d-flex align-items-center text-danger">
                                                    <i class="material-icons mr-1">cancel</i>Rechazado
                                                </div>
                                                @elseif($order->status == 'refunded')
                                                <div class="d-flex align-items-center text-danger">
                                                    <i class="material-icons mr-1">settings_backup_restore</i>Reembolsado
                                                </div>
                                                @elseif($order->status == 'charged_back')
                                                <div class="d-flex align-items-center text-danger">
                                                    <span class="material-symbols-outlined mr-1">
                                                        send_money
                                                    </span>
                                                    Contracargo
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach($order->memberships as $membresia)
                                                <span class="badge badge-info d-block my-1">
                                                    {{ $membresia->title }}
                                                </span>
                                                @endforeach
                                            </td>
                                            <td class="td-actions">
                                                <div class="btn-group m-0 d-flex" style="box-shadow: none !important">
                                                    <a class="btn btn-info btn-link" href="{{ route('sales.show', $order->id) }}" target="_blank">
                                                        <i class=" material-icons">visibility</i>
                                                    </a>
                                                    <a class="btn btn-success btn-link " href="{{ route('sales.edit', $order->id) }}" target="_blank">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <button class="btn btn-success btn-link text-danger " onclick="confirmDelete('{{ $order->id }}', '{{ $order->status }}')">
                                                        <i class="material-icons text-danger">close</i>
                                                    </button>
                                                </div>

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
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header card-header-icon card-header-primary">
                            <div class="card-icon">
                                <i class="material-icons">circles_ext</i>
                            </div>
                            <h4 class="card-title">
                                {{$user->ips->count()}} {{$user->ips->count() == 1 ? 'ip':'ips'}}
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped text-xs">
                                    <thead>
                                        <tr>
                                            <th style="cursor:pointer">
                                                IP
                                            </th>
                                            <th style="cursor:pointer">
                                                Primer ingreso
                                            </th>
                                            <th style="cursor:pointer">
                                                Ultimo ingreso
                                            </th>

                                            <th style="cursor:pointer">
                                                Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->ips as $ip)
                                        <tr>

                                            <td>{{ $ip->ip }}</td>
                                            <td>{{date_format($ip->created_at, 'd-M-Y g:i a')}} ({{ $ip->tipo }}) </td>
                                            <td>
                                                @if($ip->last_entry != '0000-00-00 00:00:00')
                                                {{date_format(new DateTime($ip->last_entry), 'd-M-Y g:i a')}} ({{ $ip->last_type }})
                                                @else
                                                -
                                                @endif


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
                                                <div class="d-flex align-items-center">
                                                    <i class="material-icons text-danger ml-1">cancel</i>
                                                    <span>Locked</span>
                                                </div>

                                                @else
                                                <div class="d-flex align-items-center">
                                                    <i class="material-icons text-success mr-1">check_circle</i>
                                                    <span>Active</span>
                                                </div>
                                                @endif
                                            </td>

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

<script>
    //Confirmar eliminar la membresía
    function confirmActive($id, $email) {
        swal({
            title: "¿Realmente quiere verificar el email: " + $email + "  ? ",
            type: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, verificar!",
        }).then((result) => {
            if (result.value) {
                Livewire.dispatch('verificar-email', {
                    id: $id
                });
            } else {
                Swal('Cancelado', 'Tu archivo está seguro :)');
            }
        });
    }
</script>