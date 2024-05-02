<div class="row">
    <div class="col-12 mb-3">
        <div class="row justify-content-center">
            <div class="col-auto  px-0">
                <div style="width: 80px !important;" class="  ">
                    @include('includes.svg.prueba')
                </div>
            </div>
            <div class="col-auto r d-flex align-items-center px-0">
                <h1 class="text-center text-primary text-2xl  lg:text-4xl font-bold ">
                    Conoce nuestras novedades
                </h1>
            </div>
            <div class="col-12">
                <p class="text-center text-muted"> ¡Descubre nuestros materiales didácticos más recientes! </p>
            </div>
        </div>

    </div>

    <div class="novedades-autoplay px-0 mb-0 pb-0">
        @if (isset($products) && $products->count() > 0)
        @foreach ($products as $product)
        <div class="px-1">
            <div class="card card-primary card-product  ">
                <div class="card-header card-header-image" data-header-animation="false">
                    <a href="{{ route('shop.show', $product->slug) }}">
                        @if($product->video)
                        <video class="rounded  w-75 " src="{{ Storage::url($product->video) }}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                        @else
                        <img class="img" src="{{ Storage::url($product->itemMain) }} " style="max-height:100% ;">
                        @endif
                    </a>
                </div>
                <div class="card-body   px-1">
                    <div class="text-center">
                        @if(!\Cart::get($product->id))
                        <button class=" btn  btn-primary btn-round  px-2 w-full " wire:click="addCart('{{ $product->id }}','Product')" wire:loading.attr="disabled">
                            <div class="d-flex align-items-center ">
                                <i class="material-icons mr-2 ">shopping_cart</i>
                                <span class="text-xs fw-bold">Agregar al carrito</span>
                            </div>
                        </button>
                        @else
                        <a href="{{ route('cart.index') }}" class="btn btn-primary btn-round">
                            <div class="d-flex align-items-center">
                                <i class="material-icons mr-2">shopping_cart</i>
                                <span class="text-xs fw-bold">Ver en el carrito</span>
                            </div>
                        </a>
                        @endif
                    </div>
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
        @endif
    </div>
</div>