<div class="content py-0 bg-white">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row justify-content-between">
                    <div class="col-12    d-flex justify-content-center">
                        <div class="search-panels w-75">
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
            </div>
            <div class="col-12">
                @if ($search != '')
                <div class="card">

                    <div class="card-body row">

                        @if ($search != '')
                        <div class="col-12">
                            <small class="text-primary">{{ $orders->count() }} resultados obtenidos</small>
                        </div>
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
                                        <th style="cursor:pointer" wire:click="setSort('payment_id')">
                                            @if($sortField=='payment_id')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif

                                            Id MP
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
                                                <span>Cantidad</span>
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
                                        <td>{{ $order->payment_id }}</td>
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
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">

                                    <i class="material-icons">equalizer</i>
                                </div>
                                <p class="card-category">Ventas del día</p>
                                <h3 class="card-title"> ${{ number_format($salesDay,2) }} </h3>
                            </div>
                            <div class="card-footer p-0">
                                <div class="stats">
                                    <input class="form-control" type="text" value="" placeholder="" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">timeline</i>
                                </div>
                                <p class="card-category">Ventas del mes de {{$monthSelectName}} {{$yearSelect}}</p>
                                <h3 class="card-title">${{ number_format($salesMonth,2) }} </h3>
                            </div>
                            <div class="card-footer p-0">
                                <div class="stats ">
                                    <select class="form-control text-muted" wire:model.live="monthSelect" wire:change="setNames()">
                                        <option selected value="">Selecciona el mes...</option>
                                        <option value="01">Enero</option>
                                        <option value="02">Febrero</option>
                                        <option value="03">Marzo</option>
                                        <option value="04">April</option>
                                        <option value="05">Mayo</option>
                                        <option value="06">Junio</option>
                                        <option value="07">Julio</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                    @if( $monthSelect != now()->format('m') )
                                    <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="clearMonth()">close</i>
                                    @endif

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">calendar_month</i>
                                </div>
                                <p class="card-category">Ventas del año</p>
                                <h3 class="card-title">${{ number_format($salesYear,2) }} </h3>
                            </div>
                            <div class="card-footer p-0">
                                <div class="stats">
                                    <select class="form-control" name="fop" wire:model.live="yearSelect">
                                        <option selected value="">Selecciona el año...</option>
                                        @for ($i = 2020; $i < 2030; $i++) <option value="{{$i}}"> {{$i}} </option>
                                            @endfor
                                    </select>

                                    @if( $yearSelect != now()->format('Y') )
                                    <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="$set('yearSelect', '{{now()->format('Y')}}')">close</i>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats">

                            <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">date_range</i>
                                </div>
                                <p class="card-category">Ventas por rango</p>
                                <h3 class="card-title">${{ number_format($salesRange,2) }} </h3>
                            </div>
                            <div class="card-footer p-0" wire:ignore>
                                <div class="stats">
                                    <input class="form-control" type="text" name="datefilter" value="" placeholder="Seleccione rango..." />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons"></i>
                                </div>
                                <h4 class="card-title">Detalle de ventas por día</h4>
                            </div>
                            <div class="card-body ">
                                <div class="table-responsive table-sales mt-2">
                                    <table class="table">
                                        <thead>
                                            <tr>

                                                <th class="font-weight-bold">
                                                    Titulo
                                                </th>
                                                <th class="font-weight-bold">
                                                    Ventas
                                                </th>
                                                <th class="font-weight-bold">
                                                    Suma
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $sumProducts=0;
                                            $sumPackages=0;
                                            $sumMemberships=0;
                                            @endphp

                                            @foreach($productsDay as $product)
                                            <tr>
                                                <td>
                                                    {{$product->title}}
                                                </td>
                                                <td class="text-center">
                                                    {{$product->sales_count}}
                                                </td>
                                                <td class="text-end">
                                                    {{ number_format( $product->sales_sum_price,2)}}
                                                </td>
                                            </tr>
                                            @php
                                            $sumProducts=$sumProducts+$product->sales_sum_price
                                            @endphp
                                            @endforeach

                                            <tr class="fw-bold table-success">
                                                <td>Ventas de productos</td>
                                                <td></td>
                                                <td class="text-end fw-bold">{{ number_format( $sumProducts,2)}} </td>
                                            </tr>

                                            @foreach($packagesDay as $product)
                                            <tr>
                                                <td>
                                                    {{$product->title}}
                                                </td>
                                                <td class="text-center">
                                                    {{$product->sales_count}}
                                                </td>
                                                <td class="text-end">
                                                    {{ number_format( $product->sales_sum_price,2)}}
                                                </td>
                                            </tr>
                                            @php
                                            $sumPackages=$sumPackages+$product->sales_sum_price
                                            @endphp
                                            @endforeach
                                            <tr class="fw-bold table-success">
                                                <td>Ventas de productos</td>
                                                <td></td>
                                                <td class="text-end fw-bold">{{ number_format( $sumPackages,2)}} </td>
                                            </tr>
                                            @foreach($membershipsDay as $product)
                                            <tr>
                                                <td>
                                                    {{$product->title}}
                                                </td>
                                                <td class="text-center">
                                                    {{$product->sales_count}}
                                                </td>
                                                <td class="text-end">
                                                    {{ number_format( $product->sales_sum_price,2)}}
                                                </td>
                                            </tr>
                                            @php
                                            $sumMemberships=$sumMemberships+$product->sales_sum_price
                                            @endphp
                                            @endforeach
                                            <tr class="fw-bold table-success">
                                                <td>Ventas de productos</td>
                                                <td></td>
                                                <td class="text-end fw-bold">{{ number_format( $sumMemberships,2)}} </td>
                                            </tr>
                                            <tr class=" fw-bold" style="border-top:solid 2px ">
                                                <td class="text-success">Total de ventas</td>
                                                <td></td>
                                                <td class="text-end text-success">{{ number_format( $sumMemberships+$sumPackages+$sumProducts,2)}} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">trending_up</i>
                                </div>
                                <h4 class="card-title">Global Sales Top 10 web</h4>
                            </div>
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive table-sales">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="font-weight-bold">
                                                            Imagen
                                                        </th>
                                                        <th class="font-weight-bold">
                                                            Titulo
                                                        </th>
                                                        <th class="font-weight-bold">
                                                            Ventas
                                                        </th>
                                                        <th class="font-weight-bold">
                                                            Suma ventas
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if( isset($topProducts) && $topProducts != null )

                                                    @foreach($topProducts as $product)
                                                    <tr>
                                                        <td class=" py-1">

                                                            <img src="{{ Storage::url($product->itemMain) }} " width="60">

                                                        </td>
                                                        <td>
                                                            {{$product->title}}
                                                        </td>
                                                        <td>
                                                            {{$product->sales_count}}
                                                        </td>
                                                        <td>
                                                            {{ number_format( $product->sales_sum_price,2)}}
                                                        </td>
                                                    </tr>

                                                    @endforeach

                                                    @endif



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






        </div>
    </div>

    <script>
        //Confirmar eliminar producto
        function confirmDeleteIP(id, $name) {
            swal({
                title: "Realmente desea eliminar la IP: " + $name,
                //type: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!",
            }).then((result) => {
                if (result.value) {
                    Livewire.dispatch('deleteIPssss');
                } else {
                    Swal.fire('La IP está segura :)', '', 'info')
                }
            });
        }
    </script>
</div>