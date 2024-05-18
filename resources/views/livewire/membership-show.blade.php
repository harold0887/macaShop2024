<div class="container bg-white shadow my-1 rounded">
    @include('includes.spinner-livewire')
    <div class="content-main  rounded">
        <div class="row">
            <div class="col-12 ">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('membership')}}">Membresía VIP</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $membership->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- row main -->
        <div class="row justify-content-center">
            <!-- col left -->
            <div class="col-12 col-md-4 col-lg-3 ">
                <div class=" membership-sticky animate__animated  animate__shakeX animate__repeat-1	  card card-primary card-product {{($membership->discount_percentage < $membership->price) ? 'border  border-primary' : 'border' }}" data-mdb-sticky-boundary="true" style=" overflow: hidden;">
                    @if($membership->start > now())
                    <div class="price-label bg-primary animate__animated  animate__flash animate__infinite 	infinite"><span>Preventa</span></div>
                    @else
                    @if($membership->price > $membership->price_with_discount)
                    <div class="price-label bg-primary animate__animated  animate__flash animate__infinite 	infinite"><span>Oferta</span></div>
                    @endif
                    @endif
                    <div class="card-header card-header-image mt-2" data-header-animation="false">

                        <img class="img" src="{{ Storage::url($membership->itemMain) }} ">

                    </div>
                    <div class="card-body   px-1">
                        <div class="text-center">
                            @if (!\Cart::get($membership->id))
                            <button class=" btn btn-lg btn-primary btn-round   w-full " wire:click="addCart('{{ $membership->id }}','{{ $membership->model }}' )" wire:loading.attr="disabled">
                                <div class="d-flex align-items-center ">
                                    <i class="material-icons mr-2 ">shopping_cart</i>
                                    <span class="text-xs fw-bold">Agregar al carrito</span>
                                </div>
                            </button>
                            @else
                            <a href="{{ route('cart.index') }}" class="btn btn-lg btn-primary btn-round">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons mr-2">shopping_cart</i>
                                    <span class="text-xs fw-bold">Ver en el carrito</span>
                                </div>
                            </a>
                            @endif
                        </div>
                        <h3 class="title text-center  text-sm sm:text-2x1 md:text-2xl  lg:text-2xl  my-2">
                            Membresía {{ $membership->title }}
                        </h3>
                        <div class="card-description  mt-0">
                            <span class="text-primary text-uppercase fw-bold h3 d-block text-center">
                                {{$membership->vigencia}}
                            </span>
                            @if ($membership->price > $membership->price_with_discount)
                            <span class="text-2xl  my-3 text-center d-block">
                                Antes: <span style="text-decoration:line-through;">${{ round($membership->price) }}</span>
                                <span class="text-xs">
                                    MXN
                                </span>
                            </span>
                            @endif
                            <span class="text-center fw-bold h1  text-muted">
                                {{ round($membership->price_with_discount) }}.00

                            </span>
                            <span class="text-sm">
                                MXN
                            </span>
                        </div>
                        <span class="text-center text-muted  d-block text-xxs">
                            <span class="d-block mb-1"> Vigencia:</span>

                            {{date_format(new DateTime($membership->start),'d')}} de
                            @if(date_format(new DateTime($membership->start),'M')=='Jan')
                            enero
                            @elseif(date_format(new DateTime($membership->start),'M')=='Feb')
                            febrero
                            @elseif(date_format(new DateTime($membership->start),'M')=='Mar')
                            marzo
                            @elseif(date_format(new DateTime($membership->start),'M')=='Apr')
                            abril
                            @elseif(date_format(new DateTime($membership->start),'M')=='May')
                            mayo
                            @elseif(date_format(new DateTime($membership->start),'M')=='Jun')
                            junio
                            @elseif(date_format(new DateTime($membership->start),'M')=='Jul')
                            julio
                            @elseif(date_format(new DateTime($membership->start),'M')=='Aug')
                            agosto
                            @elseif(date_format(new DateTime($membership->start),'M')=='Sep')
                            septiembre
                            @elseif(date_format(new DateTime($membership->start),'M')=='Oct')
                            octubre
                            @elseif(date_format(new DateTime($membership->start),'M')=='Nov')
                            noviembre
                            @elseif(date_format(new DateTime($membership->start),'M')=='Dec')
                            diciembre
                            @endif
                            del
                            {{date_format(new DateTime($membership->start),'Y')}}


                            al

                            {{date_format(new DateTime($membership->expiration),'d')}} de
                            @if(date_format(new DateTime($membership->expiration),'M')=='Jan')
                            enero
                            @elseif(date_format(new DateTime($membership->expiration),'M')=='Feb')
                            febrero
                            @elseif(date_format(new DateTime($membership->expiration),'M')=='Mar')
                            marzo
                            @elseif(date_format(new DateTime($membership->expiration),'M')=='Apr')
                            abril
                            @elseif(date_format(new DateTime($membership->expiration),'M')=='May')
                            mayo
                            @elseif(date_format(new DateTime($membership->expiration),'M')=='Jun')
                            junio
                            @elseif(date_format(new DateTime($membership->expiration),'M')=='Jul')
                            julio
                            @elseif(date_format(new DateTime($membership->expiration),'M')=='Aug')
                            agosto
                            @elseif(date_format(new DateTime($membership->expiration),'M')=='Sep')
                            septiembre
                            @elseif(date_format(new DateTime($membership->expiration),'M')=='Oct')
                            octubre
                            @elseif(date_format(new DateTime($membership->expiration),'M')=='Nov')
                            noviembre
                            @elseif(date_format(new DateTime($membership->expiration),'M')=='Dec')
                            diciembre
                            @endif
                            del
                            {{date_format(new DateTime($membership->expiration),'Y')}}
                        </span>
                        <p class="text-muted text-start m-3">


                            {!! $membership->information !!}

                        </p>
                    </div>
                    <div class="card-footer">
                        <p class="text-xxs">
                            <span class="text-danger">Importante:</span>
                            <span class=" text-muted"> La membresía no incluye todo el material didáctico de la TIENDA.</span>
                        </p>


                    </div>
                </div>







            </div>
            <!-- col right -->
            <div class="col-12 col-md-8 col-lg-9     ">
                <div class="row">

                    <div class="col-12">
                        <h2 class="title text-center text-primary text-sm sm:text-2x1 md:text-2xl  lg:text-2xl border-bottom">
                            Consulta la lista de materiales didácticos incluidos en la membresía {{ $membership->title }}
                        </h2>
                    </div>

                </div>
                <!-- row title -->
                <div class="row">
                    @if ($membership->products->count() > 0)
                    @foreach ($membership->products as $product)
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
                                @foreach($product->categorias as $categoria)
                                <span class="badge badge-sm badge-success mr-1" style="cursor:pointer" wire:click="setCategory('{{ $categoria->id }}')">{{$categoria->name}}</span>
                                @endforeach

                            </div>
                            <div class="card-footer justify-content-end">

                                <div class="d-flex  text-info align-items-center" style="cursor: pointer;" wire:click="setProduct('{{$product->id}}')">
                                    <i class="material-icons mr-1">visibility</i><span>Vista rapida</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach

                    @else
                    <div class="col-12 mt-5 text-center">
                        <span class="h4 text-muted">La membresía está en preventa, por lo cual aún no hay materiales didácticos disponibles, agradecemos su comprensión. <span>
                    </div>

                    @endif
                </div>
            </div>
        </div>
    </div>

</div>