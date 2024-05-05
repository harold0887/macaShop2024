<div class="content py-0 bg-white">
    @include('includes.spinner-livewire')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header card-header-primary card-header-icon ">
                        <div class="card-icon">
                            <i class="material-icons">receipt</i>
                        </div>
                        <div class="row ">
                            <div class="col-12 d-flex align-items-center">
                                <h6 class="card-title font-weight-bold">Resumen de compra - {{$order->id}}</h6>
                                <a class="btn  btn-link  p-0" href="{{ route('sales.edit', $order->id) }}" target="_blank">
                                    <i class="material-icons text-success">edit</i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row ">
                        <div class="col-12 col-lg-9 order-2 order-lg-1">
                            <div class="row">
                                <!-- Content -->
                                <div class="rgba-black-strong ">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-12">

                                            <!--Accordion wrapper-->
                                            <div class="accordion md-accordion accordion-5 " id="accordionEx5" role="tablist" aria-multiselectable="true">

                                                <!-- Accordion card -->
                                                <div class="card mb-4  mt-0">

                                                    <!-- Card header -->
                                                    <div class="card-header  z-depth-1 shadow" role="tab" id="heading30">
                                                        <a data-toggle="collapse" data-parent="#accordionEx5" href="#collapse30" aria-expanded="true" aria-controls="collapse30">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-solid fa-book mr-2  float-left "></i>
                                                                <span class="text-base">Cuadernillos ({{$purchases->count()}})</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <!-- Card body -->
                                                    <div id="collapse30" class="collapse {{$purchases->count() > 0 ?'show':''}}  " role="tabpanel" aria-labelledby="heading30" data-parent="#accordionEx5">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if (isset($purchases) && $purchases->count() > 0)

                                                            @foreach($purchases as $product)


                                                            <div class="row pt-2">
                                                                <div class="col-md-2 my-1">
                                                                    <img src="{{ Storage::url($product->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <span class="fw-bold text-muted">{{ $product->title }}</span>

                                                                    <span class="d-block">Precio: ${{ $product->price }}</span>
                                                                </div>

                                                                <div class="col-12 col-md-2 text-center align-self-center">

                                                                    @if($product->folio == 1 && $product->active == 0 )
                                                                    <small>Este documento requiere activación.</small>
                                                                    <br><br>

                                                                    <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20orden%20de%20compra%20web: {{ $product->order_id }}" target="_blank">
                                                                        <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                                    </a>

                                                                    @else

                                                                    @if(Storage::exists($product->document))
                                                                    <div wire:loading.remove>
                                                                        <button class="btn btn-outline-info btn-round w-100" wire:click.prevent="download('{{ $product->id }}')">
                                                                            <i class="material-icons">download</i> Descargar
                                                                        </button>
                                                                    </div>
                                                                    <button class="btn btn-outline-primary btn-round w-100" type="button" disabled wire:loading wire:target="resend">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        enviando...
                                                                    </button>

                                                                    <button class="btn btn-outline-info btn-round w-100" type="button" disabled wire:loading wire:target="download">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        Descargando...
                                                                    </button>
                                                                    @else

                                                                    <div>
                                                                        <button class="btn btn-link btn-round w-100 btn-danger" disabled>
                                                                            <i class="material-icons">file_download_off</i> Expired
                                                                        </button>
                                                                    </div>
                                                                    @endif



                                                                    @endif




                                                                </div>

                                                                <div class="col-12">
                                                                    @if(isset($enviados) && $enviados->count() > 0)

                                                                    <table class="table table-hover table-responsive ">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><b>Email</b></th>
                                                                                <th><b>Fecha de envio</b></th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="h5 ">
                                                                            @foreach($enviados as $enviado)
                                                                            @if ($enviado->product_id== $product->id && $enviado->order_id== $order->id)
                                                                            <tr>
                                                                                <td>{{$enviado->emal}}</td>
                                                                                <td>{{$enviado->created_at}}</td>
                                                                            </tr>
                                                                            @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    @endif
                                                                </div>


                                                            </div>
                                                            <hr style="border: solid 1px red;">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion card -->

                                                <!-- Accordion card -->
                                                <div class="card mb-4">

                                                    <!-- Card header -->
                                                    <div class="card-header  z-depth-1 shadow" role="tab" id="heading31">
                                                        <a data-toggle="collapse" data-parent="#accordionEx5" href="#collapse31" aria-expanded="true" aria-controls="collapse31">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-solid fa-cubes mr-2  float-left "></i>
                                                                <span class="text-base">Paquetes ({{$packages->count()}})</span>
                                                            </div>

                                                        </a>
                                                    </div>

                                                    <!-- Card body -->
                                                    <div id="collapse31" class="collapse {{$packages->count() > 0 ?'show':''}}" role="tabpanel" aria-labelledby="heading31" data-parent="#accordionEx5">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if(isset($packages) && $packages->count() > 0)
                                                            @foreach($packages as $package)
                                                            <div class="row pt-2">
                                                                <div class="col-md-2 my-1">
                                                                    <img src="{{ Storage::url($package->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <span class="fw-bold text-muted">{{ $package->title }}</span>
                                                                    <span class="d-block">Precio: ${{ $package->price }}</span>

                                                                </div>
                                                                <div class="col-12 col-md-2 text-center align-self-center">

                                                                    @if($package->active == 0 )
                                                                    <small>Este paquete requiere activación.</small>
                                                                    <br><br>

                                                                    <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20orden%20de%20compra%20web: {{ $package->order_id }}" target="_blank">
                                                                        <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                                    </a>
                                                                    <div wire:loading.remove>
                                                                        <button class="btn btn-outline-info btn-round w-100" wire:click="showPackages('{{ $package->id }}')">
                                                                            ver materiales
                                                                        </button>
                                                                    </div>

                                                                    @else
                                                                    <div wire:loading.remove>
                                                                        <button class="btn btn-outline-info btn-round w-100" wire:click="showPackages('{{ $package->id }}')">
                                                                            ver materiales
                                                                        </button>
                                                                    </div>
                                                                    <button class="btn btn-outline-info btn-round w-100" type="button" disabled wire:loading wire:target="download">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        Descargando...
                                                                    </button>

                                                                    @endif





                                                                </div>

                                                            </div>
                                                            {{$package->products1}}
                                                            <hr class="text-muted">

                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion card -->

                                                <!-- Accordion card -->
                                                <div class="card mb-4">

                                                    <!-- Card header -->
                                                    <div class="card-header  z-depth-1 shadow" role="tab" id="heading32">
                                                        <a data-toggle="collapse" data-parent="#accordionEx5" href="#collapse32" aria-expanded="true" aria-controls="collapse32">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-solid fa-id-card mr-2  float-left "></i>
                                                                <span class="text-base">Membresías ({{$memberships->count()}})</span>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <!-- Card body -->
                                                    <div id="collapse32" class="collapse {{$memberships->count() > 0 ?'show':''}}" role="tabpanel" aria-labelledby="heading32" data-parent="#accordionEx5">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if(isset($memberships) && $memberships->count() > 0)
                                                            @foreach($memberships as $membership)


                                                            <div class="row pt-2">
                                                                <div class="col-md-2 my-1">
                                                                    <img src="{{ Storage::url($membership->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <span class="fw-bold text-muted">{{ $membership->title }}</span>
                                                                    <span class="d-block">Precio: ${{ $membership->price }}</span>

                                                                </div>
                                                                <div class="col-12 col-md-2 text-center align-self-center">
                                                                    @if($membership->active == 0 )
                                                                    <small>Esta membresía requiere activación.</small>
                                                                    <br><br>

                                                                    <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20orden%20de%20compra%20web: {{ $membership->order_id }}" target="_blank">
                                                                        <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                                    </a>


                                                                    @else


                                                                    @endif

                                                                </div>

                                                            </div>
                                                            <hr class="text-muted">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion card -->
                                                <!-- Accordion card -->
                                                <div class="card mb-4">

                                                    <!-- Card header -->
                                                    <div class="card-header  z-depth-1 shadow" role="tab" id="heading32">
                                                        <a data-toggle="collapse" data-parent="#accordionEx6" href="#collapse33" aria-expanded="true" aria-controls="collapse33">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-solid fa-list mr-2  float-left "></i>
                                                                <span class="text-base">Productos del paquete ({{$productsPackagesOrder->count()}})</span>
                                                            </div>

                                                        </a>
                                                    </div>

                                                    <!-- Card body -->
                                                    <div id="collapse33" class="collapse {{$productsPackagesOrder->count() > 0 ?'show':''}}" role="tabpanel" aria-labelledby="heading32" data-parent="#accordionEx6">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if(isset($productsPackagesOrder) && $productsPackagesOrder->count() > 0)
                                                            @foreach($productsPackagesOrder as $product)
                                                            <div class="row pt-2">
                                                                <div class="col-md-2 my-1">
                                                                    <img src="{{ Storage::url($product->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <span class="fw-bold text-muted">{{ $product->title }}</span>
                                                                    <span class="d-block">Precio: ${{ $product->price }}</span>
                                                                    @if($product->status==0)
                                                                    <span class="text-danger">Product disabled </span>
                                                                    @endif

                                                                </div>
                                                                <div class="col-12 col-md-2 text-center align-self-center">

                                                                    @if($product->folio == 1 && $order->active == 0 )
                                                                    <small>Este documento requiere activación.</small>
                                                                    <br><br>

                                                                    <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20orden%20de%20compra%20web: {{ $product->order_id }}" target="_blank">
                                                                        <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                                    </a>

                                                                    @else
                                                                    <div wire:loading.remove>

                                                                        <button class="btn btn-outline-info btn-round w-100" wire:click.prevent="download('{{ $product->id }}')">
                                                                            <i class="material-icons">download</i> Descargar
                                                                        </button>
                                                                    </div>
                                                                    <button class="btn btn-outline-info btn-round w-100" type="button" disabled wire:loading wire:target="download">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        Descargando...
                                                                    </button>
                                                                    @endif




                                                                </div>
                                                                <div class="col-12">
                                                                    @if(isset($enviados) && $enviados->count() > 0)

                                                                    <table class="table table-hover table-responsive ">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><b>Email</b></th>
                                                                                <th><b>Fecha de envio</b></th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="h5 ">
                                                                            @foreach($enviados as $enviado)
                                                                            @if ($enviado->product_id== $product->id )
                                                                            <tr>
                                                                                <td>{{$enviado->emal}}</td>
                                                                                <td>{{$enviado->created_at}}</td>
                                                                            </tr>
                                                                            @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    @endif
                                                                </div>


                                                            </div>
                                                            <hr style="border: solid 1px red;">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion card -->
                                            </div>
                                            <!--/.Accordion wrapper-->

                                        </div>
                                    </div>
                                </div>
                                <!-- Content -->

                            </div>


                        </div>
                        <div class="col order-1 order-lg-2">
                            <div class="d-flex align-items-center">
                                <span class="text-muted fw-bold">Status de pago:</span>
                                <div class="ml-2">
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
                                    <div class="d-flex align-items-center text-danger ">
                                        <span class="material-symbols-outlined mr-1">
                                            send_money
                                        </span>
                                        Contracargo
                                    </div>
                                    @endif
                                </div>
                            </div>



                            <span class="fw-bold text-muted mr-2">Email: </span><span class="font-italic">{{ $order->user->email }}</span>
                            <br>
                            <span class="fw-bold text-muted mr-2">WhatsApp: </span><span class="font-italic">{{ $order->user->whatsapp }}</span>

                            <br>
                            <span class="fw-bold text-muted mr-2">Facebook: </span><span class="font-italic">{{ $order->user->facebook }}</span>

                            <br>
                            <span class="fw-bold text-muted mr-2">Fecha: </span><span class="font-italic">{{ date_format($order->created_at, 'd-M-Y g:i a') }}</span>
                            <br>
                            <span class="fw-bold text-muted mr-2">Total: </span><span class="font-italic">{{ $order->amount }} MXN</span>
                            <br>
                            <span class="fw-bold text-muted mr-2">Pago: </span><span class="font-italic">{{ $order->payment_type }}</span>
                            <br>
                            <span class="fw-bold text-muted mr-2">Active: </span><span class="font-italic">{{ $order->active == 1 ? 'Yes' : 'No' }}</span>
                            <br>
                            <span class="fw-bold text-muted mr-2">Comentarios: </span><span class="font-italic">{{ $order->contacto }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>



</div>