<div class="container bg-white shadow my-1 rounded ">
    @include('includes.spinner-livewire')
    <div class="content-main rounded">
        <div class="row">
            <div class="col-12 ">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0 text-xs lg:text-base">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Tienda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gratuitos</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">
                <!--row products-->
                <div class="row  justify-center mt-5">
                    @if (isset($products) && $products->count() > 0)
                    @foreach ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3 mb-4 " style="position: relative; padding:5px !important">
                        <div class="card card-primary  card-product">
                            <div class="card-header  card-header-image" data-header-animation="true">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    @if($product->video)
                                    <video class="rounded  w-75 " src="{{ Storage::url($product->video) }}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                                    @else
                                    <img class="img" src="{{ Storage::url($product->itemMain) }} ">
                                    @endif

                                </a>
                            </div>
                            <div class="card-body px-1">
                                <div class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <button class="btn  btn-primary btn-round mt-2" wire:click="downloadFree('{{ $product->id }}')" wire:loading.attr="disabled">
                                            <div class="d-flex align-items-center ">
                                                <i class="material-icons mr-2 ">download</i>
                                                <span class="text-xs fw-bold">Descargar</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                                <h3 class="card-title   text-base my-2 d-flex align-items-center justify-content-center">
                                    <a href="{{ route('shop.show', $product->slug) }}"><span class="text-xs">{{ $product->title }}</span></a>
                                    @role('admin')
                                    <a class="btn btn-success btn-link p-0" href="{{ route('products.edit', $product->id) }}" target="_blank">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    @endrole
                                </h3>
                            </div>
                            <div class="card-footer">

                                <div class=" stats">
                                    <p class="item-discount text-primary fw-bold">Material gratuito</p>
                                </div>
                                <div class="price">
                                    <p class="item-price text-primary ">$ {{ $product->price_with_discount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-12 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                    @else
                    <div class="col-12 col-lg-8 text-right">
                        <video class="rounded  w-75 " src="{{asset('img/oops.mp4')}}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-11 col-lg-3 order-first order-lg-last  ">
                @if(isset($membership) && $membership->count()>0)
                <div class="row membership-sticky bg-white rounded">
                    <div class="col-12 {{($membership->discount_percentage < $membership->price) ? 'order-first order-lg-0' : '' }}" style="position: relative">
                        <div class=" animate__animated  animate__shakeX animate__repeat-1	 animate__slow  card card-primary card-product {{($membership->discount_percentage < $membership->price) ? 'border  border-primary' : 'border' }}" style=" overflow: hidden;">
                            @if ($membership->discount_percentage > 0)

                            <div class="price-label bg-primary animate__animated  animate__flash animate__infinite 	infinite	 animate__slow "><span>Oferta</span></div>
                            @endif
                            <div class="card-header card-header-image mt-2" data-header-animation="false">
                                <a href="{{route('membership.show',$membership->slug)}}">
                                    <img class="img" src="{{ Storage::url($membership->itemMain) }} ">
                                </a>
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
                                <h3 class="card-title text-center text-dark my-3 text-muted">
                                    <a href="{{route('membership.show',$membership->slug)}}">Membresía {{ $membership->title }}</a>
                                </h3>
                                <div class="card-description">
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
                                <span class="text-center text-sm d-block mt-3">
                                    Vigencia:

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
                                    {{ Str::limit($membership->information, $limit = 220, $end = '...') }}
                                </p>
                            </div>
                            <div class="card-footer justify-content-center">
                                <a href=" {{route('membership.show',$membership->slug)}} " class="btn   btn-link text-primary">
                                    Más informacion
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>