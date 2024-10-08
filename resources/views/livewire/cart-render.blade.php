<div class="container bg-white shadow my-1 rounded ">
    @include('includes.modal.login-modal')
    @include('includes.spinner-livewire')
    <div class="content-main">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0 text-xs lg:text-base">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Tienda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Carrito de compras</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if (\Cart::getContent()->count() > 0)
        <div class="row mt-2 ">
            <div class="col-12">
                <span class="lg:pt-5  md:text-3xl  text-center  text-2xl text-muted">
                    Mi carrito
                </span>
                <p class="pb-0 pb-lg-3 text-sm lg:text-lg text-muted">
                    Revise su pedido y luego continúe con el pago.
                </p>
            </div>
        </div>
        @endif



        <div class="row justify-content-between">
            @if (\Cart::getContent()->count() > 0)
            <div class="col-12 col-lg-5 justify-content-center">
                @foreach (\Cart::getContent() as $item)

                <div class="row  justify-content-center">
                    <div class="col-6 col-md-3  ">
                        <img src="{{ Storage::url($item->associatedModel->itemMain) }} " class="img-thumbnail">
                    </div>
                    <div class="col-12  col-md-6 ">
                        @if ($item->associatedModel->model == 'Product')
                        <span class="d-block fw-bold text-muted">{{ $item->name }}</span>
                        <span class="d-block text-muted">Formato digital: {{ $item->associatedModel->format }}</span>

                        @elseif($item->associatedModel->model == 'Membership')

                        @if( $item->id==2013)
                        <span class="d-block fw-bold text-muted">{{ $item->name }}</span>
                        @else
                        <span class="d-block fw-bold text-muted">Membresia {{ $item->name }}</span>
                        <span class="d-block text-muted">Vigencia:
                            @php
                            $year=\Carbon\Carbon::parse($item->associatedModel->expiration)->format('Y');
                            $month=\Carbon\Carbon::parse($item->associatedModel->expiration)->format('M');
                            @endphp
                            @if($month=='Jan')
                            Enero
                            @elseif($month=='Feb')
                            Febrero
                            @elseif($month=='Mar')
                            Marzo
                            @elseif($month=='Apr')
                            Abril
                            @elseif($month=='May')
                            Mayo
                            @elseif($month=='Jun')
                            Junio
                            @elseif($month=='Jul')
                            Julio
                            @elseif($month=='Aug')
                            Agosto
                            @elseif($month=='Sep')
                            Septiembre
                            @elseif($month=='Oct')
                            Octubre
                            @elseif($month=='Nov')
                            Noviembre
                            @elseif($month=='Dec')
                            Diciembres
                            @endif
                            {{$year}}
                        </span>
                        @endif



                        @elseif($item->associatedModel->model == 'Package')
                        <span class="d-block fw-bold text-muted">{{ $item->name }}</span>
                        @endif
                        <span class="d-block text-muted">Precio: ${{ number_format($item->price,2) }} MXN</span>
                        <span class="d-block text-muted">Cantidad: {{ $item->quantity }}</span>

                    </div>
                    <div class="col-md-3 text-end ">
                        <button class="btn  btn-link p-0 text-xxs btn-sm" wire:click="remove('{{ $item->id }}','{{ $item->associatedModel->title }}')" wire:loading.attr="disabled">
                            <i class="material-icons">close</i>
                            Eliminar
                        </button>
                    </div>
                </div>
                @if (!$loop->last)
                <hr class="text-muted border border-primary">
                @endif

                @endforeach
            </div>

            <div class="col-12 col-lg-3 mt-5 mt-lg-0 px-4">

                @role('admin')
                @if($emailExist)
                <small class=" text-success">El email ya existe</small>
                @endif
                @if(isset($userValidate) && $userValidate->whatsapp)
                <small class=" text-success"> y cuenta con whatsApp registrado</small>
                @endif
                <div class="row membership-sticky bg-white rounded shadow ">
                    <div class="col-12    text-center">
                        <span class=" h3">Resumen de la orden</span>
                    </div>
                    <div class="col-7  py-4 text-muted">Subtotal {{ \Cart::getTotalQuantity() }} artículo(s): </div>
                    <div class="col-5 py-4 text-end text-muted">${{ \Cart::getTotal() }} MXN</div>
                    <div class="col-12">
                        <hr class="text-muted">
                    </div>
                    <div class="col-6  font-weight-bold h3">Total: </div>
                    <div class="col-6  font-weight-bold text-end h3">${{ \Cart::getTotal() }} MXN</div>
                    <div class="col-12 pt-3">
                        <div class="row ">
                            <div class="col-11">
                                <input type="text" class="form-control rounded " placeholder="Email (obligatorio)" wire:model="email">
                                @error('email')
                                <small class=" text-danger"> {{ $message }} </small>
                                @enderror

                            </div>
                            <!-- <div class="col-auto  px-0 text-center">
                                <button class="btn btn-success btn-link text-primary mx-0 px-0" wire:click.delay.longest="validateEmail">
                                    <i class="material-icons text-primary">person_search</i>
                                </button>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-11 pt-3">
                        <input type="text" class="form-control rounded " placeholder="WhatsApp (obligatorio)" wire:model.defer="whats">
                        @error('whats')
                        <small class=" text-danger"> {{ $message }} </small>
                        @enderror
                    </div>
                    @if($membershipExist)
                    <div class="col-11 pt-3">
                        <input type="text" class="form-control rounded " placeholder="Facebook (obligatorio)" wire:model.defer="face">
                        @error('face')
                        <small class=" text-danger"> {{ $message }} </small>
                        @enderror
                    </div>
                    @endif

                    <div class="col-12 mt-3">
                        <div class="togglebutton">
                            <label>
                                <input wire:click="changeWeb()" type="checkbox" {{ $web == 1 ? 'checked ' : '' }}>
                                <span class="toggle"></span>
                                Enviar sin comprobante
                            </label>
                        </div>
                    </div>
                    @if ( $web == 0)
                    <div class="col-12 pt-3 text-center">

                        <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                        <div>
                            <span class="btn btn-outline-primary  btn-file   btn-round">
                                <span class="fileinput-new ">Selecciona comprobante</span>
                                <input type="file" name="itemMain" accept="image/*" style="max-width: 100%;" wire:model="payment" />
                            </span>
                        </div>
                        @error('payment')
                        <small class=" text-danger"> {{ $message }} </small>
                        @enderror
                    </div>
                    @endif




                    <div class="col-12 text-center py-3">
                        <div wire:loading.remove>
                            <button class="btn btn-primary " @if($email=='' ) disabled @endif wire:click="validateUser">
                                <span>Enviar</span>
                            </button>
                        </div>
                        <button class="btn btn-outline-primary btn-round " disabled wire:loading wire:target="submit">
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            enviando...
                        </button>
                    </div>
                    @if ( $web == 0)
                    <div class="col-12 text-center">
                        @if ($payment)
                        <img class="w-75 rounded shadow" src="{{ $payment->temporaryUrl() }}">
                        @endif
                    </div>
                    @endif



                </div>


                @else
                <div class="row membership-sticky bg-white rounded shadow-sm text-muted ">
                    <div class="col-12    text-center">
                        <span class=" h3">Resumen de la orden</span>
                    </div>
                    <div class="row justify-content-between py-4">
                        <div class="col-auto">Subtotal {{ \Cart::getTotalQuantity() }} artículo(s): </div>
                        <div class="col-auto">${{ \Cart::getTotal() }}.00 MXN</div>
                    </div>

                    <div class="col-12">
                        <hr class="text-muted">
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-auto  font-weight-bold h3">Total: </div>
                        <div class="col-auto  font-weight-bold text-end h3">${{ \Cart::getTotal() }}.00 MXN</div>
                    </div>

                    <div class="col-12 text-center mt-3 mt-lg-5">
                        @auth
                        <form action="{{ route('shop.createOrder') }}" method="POST" style="cursor:pointer" id="create-product-admin">
                            @csrf
                            <button class="btn btn-lg fw-bold   btn-primary btn-round  w-100">
                                Finalizar orden
                            </button>
                        </form>
                        @else
                        <button class="btn btn-lg fw-bold   btn-primary btn-round  w-100" wire:click="loginMessage()" style="cursor:pointer">
                            Finalizar orden
                        </button>
                        @endauth
                    </div>
                    <span class="text-center text-muted">
                        Los recursos comprados se pueden descargar inmediatamente desde su cuenta*
                    </span>
                </div>
                @endif


            </div>
            @else
            <div class="col-12 text-center ">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-5 ">
                        <img src="{{ asset('img/cart.png') }} " class="text-center  w-100 ">


                        <a href="{{ route('shop.index') }}" class="text-white btn btn-primary btn-lg btn-round">
                            <div class="d-flex align-items-center">
                                <i class="material-icons  mr-2 ">shopping_bag</i>
                                <span class="fw-bold">Ver tienda</span>
                            </div>

                        </a>
                    </div>
                </div>

            </div>
            @endif
        </div>
        <div class="row mt-lg-5">
            <div class="col-12 text-end mt-lg-5 pt-5">
                <small class="text-xxs text-muted">*Algunos recursos pueden solicitar activación vía WhatsApp. </small>
            </div>
        </div>
    </div>
</div>