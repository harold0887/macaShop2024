<div class="w-100">
    <div class="row justify-content-between">
        <div class="col-12   d-flex justify-content-center">
            <div class="search-panels w-100">
                <div class="search-group">
                    <input required="" type="text" name="text" autocomplete="on" class="input" wire:model.live.debounce.500ms='search'>
                    <label class="enter-label">Buscar por orden, email, etc...</label>
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
    @if ($search != '')
    <div class="row position-relative justify-content-between">
        <div class="position-absolute shadow  bg-white rounded ">
            @if (isset($orders) && $orders->count() > 0)
            <div class="table-responsive ">
                <table class="table table-striped text-xs">
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

                                Id
                            </th>

                            <th style="cursor:pointer" wire:click="setSort('created_at')">
                                <div class="d-flex">
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
                                </div>

                            </th>
                            <th style="cursor:pointer" wire:click="setSort('amount')">
                                <div class="d-flex">
                                    @if($sortField=='amount')
                                    @if($sortDirection=='asc')
                                    <i class="fa-solid fa-arrow-down-a-z"></i>
                                    @else
                                    <i class="fa-solid fa-arrow-up-z-a"></i>
                                    @endif
                                    @else
                                    <i class="fa-solid fa-sort mr-1"></i>
                                    @endif
                                    <span>Total</span>
                                </div>

                            </th>
                            <th style="cursor:pointer" wire:click="setSort('payment_type')">
                                @if($sortField=='payment_type')
                                @if($sortDirection=='asc')
                                <i class="fa-solid fa-arrow-down-a-z"></i>
                                @else
                                <i class="fa-solid fa-arrow-up-z-a"></i>
                                @endif
                                @else
                                <i class="fa-solid fa-sort mr-1"></i>
                                @endif
                                Pago
                            </th>
                            <th style="cursor:pointer" wire:click="setSort('status')">
                                <div class="d-inline-flex p-0">
                                    @if($sortField=='status')
                                    @if($sortDirection=='asc')
                                    <i class="fa-solid fa-arrow-down-a-z"></i>
                                    @else
                                    <i class="fa-solid fa-arrow-up-z-a"></i>
                                    @endif
                                    @else
                                    <i class="fa-solid fa-sort mr-1"></i>
                                    @endif
                                    <span>Status</span>
                                </div>

                            </th>
                            <th>
                                Membresía
                            </th>
                            <th>email</th>
                            <th>WhatsApp</th>
                            <th>Facebook</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr class=" {{$order->active==0
                                         ? 'table-danger':''}} ">
                            <td>{{ $order->id }}</td>

                            <td>{{date_format($order->created_at, 'd-M-Y H:i')}}</td>
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
                            <td>
                                {{ $order->user->email }}
                            </td>

                            <td>
                                {{ $order->user->whatsapp }}
                            </td>
                            <td>
                                {{ $order->user->facebook }}
                            </td>
                            <td class="td-actions">
                                <div class="btn-group m-0 d-flex" style="box-shadow: none !important">
                                    <a class="btn btn-info btn-link" href="{{ route('sales.show', $order->id) }}">
                                        <i class=" material-icons">visibility</i>
                                    </a>
                                    <a class="btn btn-success btn-link " href="{{ route('sales.edit', $order->id) }}">
                                        <i class="material-icons">edit</i>
                                    </a>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                {{ $orders->links() }}
            </div>
            @else
            <div class="col-12">
                <p class="alert alert-warning">⚠️ ¡Ooooups! No se encontraron resultados.</p>
            </div>
            @endif


        </div>
    </div>

    @endif
</div>