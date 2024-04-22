<div class="container bg-white shadow my-1 rounded">
    @include('includes.spinner-livewire')
    <div class="content-main  ">
        <div class="row">
            <div class="col-12 ">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Tienda</a></li>
                        <li class="breadcrumb-item"><a href="{{route('paquete')}}">Paquetes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $package->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center  ">
            <div class="col-10 col-md-4 col-lg-3 ">
                <div class=" membership-sticky card card-primary card-product {{($package->price_with_discount < $package->price) ? 'border  border-primary' : 'border' }}" style=" overflow: hidden;">
                    @if ($package->price_with_discount < $package->price)
                        <div class="price-label bg-primary "><span>Descuento</span></div>
                        @endif
                        <div class="card-header card-header-image mt-2" data-header-animation="false">
                            <img class="img" src="{{ Storage::url($package->itemMain) }} ">
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                @if(!\Cart::get($package->id))
                                <button class=" btn  btn-primary btn-round  px-3 w-full btn-lg" wire:click="addCart('{{ $package->id }}','Package')" wire:loading.attr="disabled">
                                    <div class="d-flex align-items-center ">
                                        <i class="material-icons mr-2 ">shopping_cart</i>
                                        <span class="text-xs fw-bold">Agregar al carrito </span>
                                    </div>
                                </button>
                                @else
                                <a href="{{ route('cart.index') }}" class="btn btn-primary btn-round btn-lg px-3 w-full">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons mr-2">shopping_cart</i>
                                        <span class="text-xs fw-bold">Ver en el carrito</span>
                                    </div>
                                </a>
                                @endif
                            </div>
                            <h3 class="card-title   text-base my-2 d-flex align-items-center justify-content-center">

                                <a href="{{route('paquete.show',$package->slug)}}">{{ $package->title }}</a>

                            </h3>

                            <div class="card-description">
                                @if ($package->discount_percentage < $package->price)
                                    <span class="text-2xl  my-3 text-center d-block">
                                        Antes: <span style="text-decoration:line-through;">${{ round($package->price) }}</span>
                                        <span class="text-xs">
                                            MXN
                                        </span>
                                    </span>
                                    @endif
                                    <span class="text-center fw-bold h1  text-muted">
                                        <small class=" text-mindle align-top ">$</small>{{ round($package->price_with_discount) }}.00

                                    </span>
                                    <span class="text-sm">
                                        MXN
                                    </span>

                                    <span class="text-muted d-block mt-3">Este paquete incluye {{ $package->products->count() }} cuadernillos.
                                    </span>
                            </div>
                        </div>
                        <div class="card-footer justify-content-center border-top">
                            <p class="text-muted text-start "> {{ $package->information }}</p>
                        </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-9 ">
                <div class="row justify-content-center ">
                    <div class="col-12">
                        <h2 class="title text-center text-primary text-sm sm:text-2x1 md:text-2xl  lg:text-2xl border-bottom">
                            Materiales didácticos incluidos en el {{ $package->title }}
                        </h2>
                    </div>
                    @foreach($package->products as $product)
                    <div class="col-6 col-md-4 col-lg-3 mb-4" style="position: relative; padding:5px !important">
                        <div class="card card-primary card-product  ">
                            <div class="card-header card-header-image" data-header-animation="true">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    @if($product->video)
                                    <video class="rounded  w-75 " src="{{ Storage::url($product->video) }}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                                    @else
                                    <img class="img" src="{{ Storage::url($product->itemMain) }} " style="max-height:100% ;">
                                    @endif
                                </a>
                            </div>
                            <div class="card-body   px-1">

                                <h3 class="card-title   text-base my-2 d-flex align-items-center justify-content-center">

                                    <a href="{{ route('shop.show', $product->slug) }}"><span class="text-xs">{{ $product->title }}</span></a>
                                    @role('admin')
                                    <a class="btn btn-success btn-link p-0" href="{{ route('products.edit', $product->id) }}" target="_blank">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    @endrole
                                </h3>
                                @foreach($product->membresias as $membresia)
                                <div class="text-center bg-info  fw-bold rounded p-0 {{$loop->index == 0 ? 'mb-1': ''}} ">
                                    <a class="my-0 mx-1" href="{{route('membership.show',$membresia->id)}}" style="cursor:pointer; text-decoration: none !important;">
                                        <span class=" text-xs  text-white">
                                            Incluido en membresía {{$membresia->title}}
                                        </span>
                                    </a>
                                </div>
                                @endforeach
                                <div class="d-flex  text-info align-items-center justify-content-center" style="cursor: pointer;" wire:click="setProduct('{{$product->id}}')">
                                    <i class="material-icons mr-1">visibility</i><span>Vista rapida</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                @if($product->price > $product->price_with_discount)
                                <div class="stats">
                                    <p style="text-decoration: line-through !important">$ {{ $product->price }}</p>
                                </div>
                                <div class="price">
                                    <p class="item-price text-primary">$ {{ $product->price_with_discount }}</p>
                                </div>
                                @else
                                <div class="stats">
                                </div>
                                <div class="price">
                                    <p class="item-price text-primary ">$ {{ $product->price_with_discount }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>



                    @endforeach




                </div>

            </div>









        </div>

    </div>
</div>