<div class="row">
    @include('includes.spinner-livewire')
    <div class="col-12 ">
        <div class="row text-xxs">
            <div class="col-auto d-flex align-items-center">
                <span class="fw-bold text-primary  my-0 py-0">Filtrar</span>
            </div>
            <div class="col-12 col-lg-auto">
                <div class="row d-flex d-flex align-items-center  px-2">
                    <label class="col-auto col-form-label  d-flex align-items-center  py-0">Desde el:</label>
                    <div class="col-auto  d-flex align-items-center">
                        <div class="form-group my-0  py-0">
                            <input type="date" class="form-control my-0 text-xxs" wire:model.live="filters.fromDate">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-auto py-0">
                <div class="row d-flex d-flex align-items-center px-2">
                    <label class="col-auto col-form-label d-flex align-items-center py-0">Hasta el:</label>
                    <div class="col-auto d-flex align-items-center ">
                        <div class="form-group my-0 py-0">
                            <input type="date" class="form-control my-0 text-xxs" wire:model.live="filters.toDate">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 my-2">
                <span class="text-primary text-xxs">{{ $orders->count() }} resultados - {{ number_format($ingresos, 2) }}</span>
            </div>
            <div class="col-12 my-2">
                <span class="text-primary text-xxs">{{ $salesExterno }} ventas Externas - {{number_format($ingresosExternal,2)}}</span>
            </div>
            <div class="col-12 my-2">
                <span class="text-primary text-xxs">{{ $salesWeb }} ventas Web - {{number_format($ingresosWeb,2)}}</span>
            </div>
        </div>
    </div>
    @if(isset($orders) && $orders->count()>0)

    <div class="table-responsive ">
        <table class="table table-striped text-xs">
            <thead>
                <tr>
                    <th>Index</th>
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
                        Order
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
                        Fecha
                    </th>
                    <th style="cursor:pointer">
                        Pago
                    </th>
                    <th style="cursor:pointer">
                        Status
                    </th>
                    <th style="cursor:pointer">
                        Price
                    </th>



                    <th>email</th>
                    <th>WhatsApp</th>
                    <th>Facebook</th>
                    <th style="cursor:pointer" wire:click="setSort('agenda')">
                        @if($sortField=='agenda')
                        @if($sortDirection=='asc')
                        <i class="fa-solid fa-arrow-down-a-z"></i>
                        @else
                        <i class="fa-solid fa-arrow-up-z-a"></i>
                        @endif
                        @else
                        <i class="fa-solid fa-sort mr-1"></i>
                        @endif
                        Agenda
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)

                <tr class=" {{$order->order->active==0 ? 'table-danger':''}} ">
                    <td>{{$loop->index+1}} </td>
                    <td>{{ $order->order->id }}</td>

                    <td>{{date_format($order->order->created_at, 'd-M-Y g:i a')}}</td>
                    <td>{{ $order->order->payment_type }}</td>
                    <td>
                        @if($order->order->status == 'create')
                        <div class="d-flex align-items-center text-muted">
                            <i class="material-icons mr-1">pending_actions</i>Pendiente de pago
                        </div>
                        @elseif ($order->order->status == 'approved')
                        <div class="d-flex align-items-center text-success">
                            <i class="material-icons mr-1">check_circle</i>Aprobado
                        </div>
                        @elseif($order->order->status == 'pending')
                        <div class="d-flex align-items-center text-muted">
                            <i class="material-icons mr-1">pending</i>Deposito pendiente
                        </div>
                        @elseif($order->order->status == 'in_process')
                        <div class="d-flex align-items-center text-muted">
                            <i class="material-icons mr-1">watch_later</i>En proceso.
                        </div>
                        @elseif($order->order->status == 'cancelled')
                        <div class="d-flex align-items-center text-danger">
                            <i class="material-icons mr-1">cancel_presentation</i>Cancelado
                        </div>
                        @elseif($order->order->status == 'rejected')
                        <div class="d-flex align-items-center text-danger">
                            <i class="material-icons mr-1">cancel</i>Rechazado
                        </div>
                        @elseif($order->order->status == 'refunded')
                        <div class="d-flex align-items-center text-danger">
                            <i class="material-icons mr-1">settings_backup_restore</i>Reembolsado
                        </div>
                        @elseif($order->order->status == 'charged_back')
                        <div class="d-flex align-items-center text-danger">
                            <span class="material-symbols-outlined mr-1">
                                send_money
                            </span>
                            Contracargo
                        </div>
                        @endif
                    </td>
                    <td>
                        {{ $order->price }}
                    </td>


                    <td>
                        {{ $order->order->user->email }}
                    </td>

                    <td>
                        {{ $order->order->user->whatsapp }}
                    </td>
                    <td>
                        {{ $order->order->user->facebook }}
                    </td>
                    <td>
                        <div class="togglebutton">
                            <label>
                                <input wire:click="updateAgenda({{ $order->id }})" type="checkbox" {{ $order->agenda == 1 ? 'checked ' : '' }}>
                                <span class="toggle"></span>
                            </label>
                        </div>
                    </td>
                    <td>
                        <input id="nota{{ $order->id }}" style="padding-top:0; padding-bottom:0; border:none;" class="border text-muted rounded" type="text" value="{{ $order->order->contacto }}">
                    </td>

                    <td>

                    </td>
                    <td class="td-actions">
                        <div class="btn-group m-0 d-flex" style="box-shadow: none !important">
                            <button class="btn btn-info btn-link text-success " onclick="udateData('{{ $order->id }}','nota{{ $order->id }}')">
                                <i class=" material-icons ">save</i>
                            </button>
                            <a class="btn btn-info btn-link" href="{{ route('sales.show', $order->order->id) }}" target="_blank">
                                <i class=" material-icons">visibility</i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>
<script>
    function udateData(id, newNote) {
        //Lanzar evento para actualizar membresia

        var nota = $('#' + newNote).val();

        Livewire.dispatch('update-data', {
            id: id,
            nota: nota
        });
    }
</script>