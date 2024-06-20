<div class="row">
    <div class="col-12 ">
        <div class="row">
            <div class="col-12">
                <h4 class="text-lg fw-bold text-muted py-0 my-0">Filtrar</h4>
            </div>
            <div class="col-auto">
                <div class="row d-flex ">
                    <label class="col-auto col-form-label  d-flex align-items-center">Desde el:</label>
                    <div class="col-auto  d-flex align-items-center">
                        <div class="form-group">
                            <input type="date" class="form-control " wire:model.live="filters.fromDate">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="row d-flex ">
                    <label class="col-auto col-form-label d-flex align-items-center">Hasta el:</label>
                    <div class="col-auto d-flex align-items-center">
                        <div class="form-group">
                            <input type="date" class="form-control" wire:model.live="filters.toDate">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h2 class="title text-center text-primary text-sm sm:text-2x1 md:text-2xl  lg:text-2xl my-0"> {{$orders->count()}} Ventas en el periodo seleccionado - {{number_format($ingresos,2)}} MXN </h2>
        </div>


    </div>
    @if(isset($orders) && $orders->count()>0)
    <div class="table-responsive ">
        <table class="table table-striped text-xs">
            <thead>
                <tr>
                    <th>Index</th>
                    <th style="cursor:pointer">
                        Order
                    </th>
                    <th style="cursor:pointer">
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

                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr class=" {{$order->order->active==0 ? 'table-danger':''}} ">
                    <td>{{$loop->index+1}} </td>
                    <td>{{ $order->id }}</td>

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

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>