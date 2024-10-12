<div class="container bg-white shadow my-1 rounded">
    @include('includes.spinner-livewire')
    <div class="content-main ">
        <div class="row">
            <div class="col-12 ">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0 text-xs lg:text-base">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Tienda</a></li>
                        <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Productos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2 class="title text-center text-primary text-sm sm:text-2x1 md:text-2xl  lg:text-2xl border-bottom">
                    {{ $product->title }}
                    @role('admin')
                    <a class="btn btn-success btn-link p-0" href="{{ route('products.edit', $product->id) }}" target="_blank">
                        <i class="material-icons">edit</i>
                    </a>
                    @endrole
                </h2>
            </div>
        </div>
        <!--row first-->
        <div class="row justify-content-around">
            <!--col left -->
            <div class="col-12 col-lg-6 ">
                <div class="row justify-content-center">
                    @if($product->video)
                    <div class="col-5 d-flex justify-content-center  px-2 px-lg-5 pb-5">
                        <video class="rounded  w-100 " src="{{ Storage::url($product->video) }}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                    </div>
                    @endif
                    <div class="@if($product->video) col-7 @else col-11 col-lg-11 @endif">
                        @include('includes.carrusel')
                    </div>
                </div>


            </div>
            <!--col right -->
            <div class="col-12 col-lg-3 mt-4 mt-lg-0">
                <!--row information -->
                <div class="row justify-content-center">
                    <div class="col-11 col-lg-12">
                        <div class="shadow rounded border border-primary  position-relative" style=" overflow:hidden !important;">
                            @if ($product->status && $product->price > $product->price_with_discount )
                            <div class="price-label bg-primary ">
                                <span>Oferta</span>
                            </div>
                            @endif
                            <div class="row justify-content-center">
                                @if($product->status)

                                <div class="col-12 text-center mt-2">
                                    @if ($product->price > $product->price_with_discount )
                                    <div class="text-muted text-sm sm:text-sm md:text-sm  lg:text-lg">
                                        Antes
                                        <span style="text-decoration:line-through;">${{ $product->price }}</span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="font-weight-bold text-muted text-2xl sm:text-3x1 md:text-3xl  lg:text-4xl ">${{ $product->price_with_discount }}</span>
                                        <span class="text-xs">MXN</span>
                                    </div>
                                    @else
                                    <span class="font-weight-bold text-muted text-2xl sm:text-3x1 md:text-3xl  lg:text-4xl ">${{ $product->price_with_discount }}</span>
                                    <span class="text-xs">MXN</span>
                                    @endif
                                </div>
                                <div class="col-12 mt-2 mt-lg-4 text-center">
                                    @if($product->price==0)
                                    <button class=" btn  btn-primary btn-round" wire:click="downloadFree('{{ $product->id }}')" wire:loading.attr="disabled">
                                        <div class="d-flex align-items-center ">
                                            <i class="material-icons mr-2">download</i>
                                            <span>Descargar</span>
                                        </div>
                                    </button>
                                    @else

                                    @if(!\Cart::get($product->id))
                                    <button class=" btn  btn-primary btn-round" wire:click="addCart('{{ $product->id }}','Product')" wire:loading.attr="disabled">
                                        <div class="d-flex align-items-center ">
                                            <i class="material-icons mr-2 ">shopping_cart</i>
                                            <span>Agregar al carrito</span>
                                        </div>
                                    </button>
                                    @else
                                    <a href="{{ route('cart.index') }}" class="btn btn-primary btn-round">
                                        <div class="d-flex align-items-center">
                                            <i class="material-icons mr-2">shopping_cart</i>
                                            <span>Ver en el carrito</span>
                                        </div>
                                    </a>
                                    @endif
                                    @endif
                                </div>
                                @else
                                <div class="col-12 text-center mt-2">
                                    <div class="m-2">
                                        <span class="text-base text-muted">{{$product->title}}, ya no está en venta o solo está disponible en alguna de nuestras membresías.</span>
                                    </div>
                                </div>

                                @endif
                            </div>
                            <div class="row @if($product->status) mt-3 @endif  justify-content-center">
                                <div class="col-12 col-lg-12 ">
                                    @include('includes.acordion')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>












        <div class="row  justify-content-around mt-5">
            <div class="col-12 col-lg-6 ">
                <div class="form-row justify-center">
                    <div class="col-12 text-center">
                        <h2 class="title text-center text-primary text-base sm:text-2x1 md:text-2xl  lg:text-2xl ">
                            Escribe sobre tu experiencia
                        </h2>
                        <small class="text-justify ">Hágales saber a otros educadores cómo usó este recurso y qué les gustó o no les
                            gustó a usted o a sus alumnos.</small>
                    </div>
                    <div class="col-12 text-center">
                        <form wire:submit.prevent="addComment">
                            <div class="form-row justify-center">
                                <div class="form-group col-md-12">
                                    <textarea type="text" @guest disabled @endguest class="form-control bg-white border  rounded @error('newComment')border-danger @enderror px-3" rows="4" wire:model.defer="newComment">

                                    </textarea>
                                </div>
                                @error('newComment')
                                <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            @auth
                            <button class=" btn btn-round btn-outline-primary" type="submit">
                                <span>Enviar comentario</span>
                            </button>
                            @else
                            <span>Regístrate o Inicia sesión para dejar un comentario.</span>
                            @endauth
                        </form>
                    </div>
                </div>
                <div class="row justify-center">
                    @if ($product->comentarios->count() > 0)
                    <div class="col-12 ">
                        <h6 class="mb-3">
                            {{$product->comentarios->count()}} Comentarios
                        </h6>
                        <div class="card card-testimonial ">
                            <div class="card-body">
                                @foreach ($product->comentarios as $item)
                                <div class="row    @if (!$loop->last) mb-3 @endif">
                                    <div class="col-auto  px-2">
                                        <div class="avatar-sm justify-content-left border ">
                                            @if(isset($item->user->picture))
                                            <img class=" border-gray m-0  w-100 avatar-sm" src="{{Storage::url($item->user->picture)}}" alt="...">

                                            @else
                                            <img class=" border-gray m-0  w-100 avatar-sm" src="{{ asset('material') }}/img/placeholder.jpg" alt="...">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col  text-left ">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6 class="card-category  m-0">
                                                    @php
                                                    $name = explode(" ", $item->user->name);
                                                    echo $name[0];
                                                    @endphp
                                                </h6>
                                                <!-- <p class=" text-muted small m-0">
                                                    {{ $item->created_at->diffForHumans() }}
                                                </p> -->
                                            </div>
                                            <div class="col-12">
                                                <p class="card-description  m-0 text-xs lg:text-sm text-gray-600 italic">
                                                    {{$item->comment}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        @if (!$loop->last)
                                        <hr class="text-muted border border-primary">
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-12">
                        <div class="card card-testimonial ">
                            <div class="card-body">
                                <small class="text-justify text-muted">
                                    <span class="font-weight-bold">
                                        Aún no hay comentarios,
                                    </span>
                                    <span>
                                        ¿quieres ser el primero en dejar uno? ¡Tu opinión nos interesa!
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-12 col-lg-6 text-center">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h2 class="title text-center text-primary text-base sm:text-2x1 md:text-2xl  lg:text-2xl ">
                            Artículos relacionados
                        </h2>
                    </div>
                    <div class="col-11 col-lg-10">
                        <section class="relacionados1">
                            @if (isset($articles) && $articles->count() > 0)
                            @foreach ($articles as $product)
                            <div class="px-2">
                                <div class="card card-product ">
                                    <div class="card-header card-header-image " data-header-animation="true">
                                        <a href="{{ route('shop.show', $product->slug) }}">
                                            @if($product->video)
                                            <video class="rounded  w-75 " src="{{ Storage::url($product->video) }}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                                            @else
                                            <img class="img" src="{{ Storage::url($product->itemMain) }} " style="max-height:100% ;">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="card-body px-1">
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
                        </section>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>