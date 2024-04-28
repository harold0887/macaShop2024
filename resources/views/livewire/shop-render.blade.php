<div class="container bg-white shadow my-1 rounded ">
    @include('includes.spinner-livewire')
    <div class="content-main ">
        <div class="row">
            <div class="col-12 ">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tienda</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row  ">
            <div class="col-12 col-lg-9">
                <!--row search-->
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8 pb-5">
                        <div class="search-panels">
                            <div class="search-group">
                                <input required="" type="text" name="text" autocomplete="on" class="input" wire:model.live.debounce.500ms='search'>
                                <label class="enter-label">Buscar</label>
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
                <!--row products-->
                <div class="row  justify-content-center px-0 mt-2">
                    @if (isset($products) && $products->count() > 2)

                    <div class="col-6 col-md-4 col-lg-3 " style="position: relative; padding:5px !important">
                        <div class=" animate__animated  animate__shakeX animate__repeat-2	 animate__slow  mt-0 card card-primary card-product {{($membership->discount_percentage > 0) ? 'border  border-primary' : 'border' }}" style=" overflow: hidden;">
                            @if ($membership->price > $membership->price_with_discount)

                            <div class="price-label bg-primary animate__animated  animate__flash animate__infinite 	infinite	 animate__slow "><span>Oferta</span></div>
                            @endif
                            <div class="card-header card-header-image mt-2" data-header-animation="false">
                                <a href="{{route('membership.show',$membership->slug)}}">
                                    <img class="img" src="{{ Storage::url($membership->itemMain) }} ">
                                </a>
                            </div>
                            <div class="card-body   px-1">
                                <div class="text-center">
                                    @if(!\Cart::get($membership->id))
                                    <button class=" btn  btn-primary btn-round  px-2 w-full " wire:click="addCart('{{ $membership->id }}','{{ $membership->model }}' )" wire:loading.attr="disabled">
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
                                <h3 class="card-title   text-base my-2">
                                    <a href="{{route('membership.show',$membership->slug)}}"><span class="text-xs">Membresía {{ $membership->title }}</span></a>
                                </h3>
                                <div class="card-description">
                                    <span class="text-primary text-uppercase fw-bold h3 d-block text-center">
                                        {{$membership->vigencia}}
                                    </span>
                                    @if ($membership->price > $membership->price_with_discount)
                                    <span class="text-2xl   mt-3 text-center d-block">
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



                                <span class="text-center text-sm d-block">
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

                            </div>
                            <div class="card-footer">
                                <p class="text-muted text-start mt-2">
                                    {{ Str::limit($membership->information, $limit = 80, $end = '...') }}
                                    <a href=" {{route('membership.show',$membership->slug)}} " style="text-decoration: none;">
                                        más informacion
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    @endif

                    @if (isset($products) && $products->count() > 0)
                    @foreach($products->filter(fn($product) => empty($products->room_bed)) as $product)

                    <div class="col-6 col-md-4 col-lg-3 " style="position: relative; padding:5px !important">
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
                    <div class="col-12 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                    @else
                    <div class="col-12 text-center">
                        <p class="alert alert-warning ">⚠️ !Oops! No se encontraron resultados, intente cambiar los filtros o la busqueda.</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-12 col-lg-3  order-first order-lg-last">
                <div class="row">
                    <div class="col-12   rounded mb-3">
                        <div class="d-flex d-block d-lg-none align-items-center py-2" id="sidebarCollapse1" style="cursor: pointer;">
                            <i id="icon-filter" class="material-icons text-primary">add </i>
                            <span class=" font-bold text-muted " id="text-filter">Mostrar filtros</span>

                        </div>


                        @if ($search != '' || $categoriesSelect != null ||$gradeSelect != null)
                        <div class=" shadow-sm rounded p-1">

                            <span class="text-base text-center d-block">
                                Busqueda actual ({{$products->total()}} resultado(s))
                            </span>


                            @if ($search != '')
                            <div class="d-flex mt-3">
                                <span class="text-muted text-base w-75">Busqueda exacta:</span>
                                <i class="close fas fa-times text-danger" style="cursor:pointer" wire:click="clearSearch()" data-placement="top" title="Borrar busqueda"></i>
                            </div>
                            <span class="badge badge-sm badge-info mr-1" wire:model.live="categoriesSelect">{{$search}}</span>
                            @endif
                            @if ($gradeSelect != null)
                            <div class="d-flex mt-3">
                                <span class="text-muted text-base  w-75">Grado(s): </span>
                                <i class="close fas fa-times text-danger" style="cursor:pointer" wire:click="clearGrade()" data-placement="top" title="Borrar grados"></i>
                            </div>

                            @if (isset($degrees) && $degrees->count() > 0)
                            @foreach ($degrees as $grade)
                            @foreach($gradeSelect as $gra)
                            @if($grade->id == $gra)
                            <span class="badge badge-sm badge-info mr-1">{{$grade->name}}</span>
                            @endif
                            @endforeach
                            @endforeach
                            @endif
                            @endif


                            @if ($categoriesSelect != null)
                            <div class="d-flex mt-3">
                                <span class="text-muted text-base w-75">Categoria(s): </span>
                                <i class="close fas fa-times text-danger" style="cursor:pointer" wire:click="clearCategories()" data-placement="top" title="Borrar categorias"></i>
                            </div>


                            @if (isset($categories) && $categories->count() > 0)
                            @foreach ($categories as $category)
                            @foreach($categoriesSelect as $cat)
                            @if($category->id == $cat)
                            <span class="badge badge-sm badge-info mr-1" wire:model.live="categoriesSelect">{{$category->name}}</span>
                            @endif
                            @endforeach
                            @endforeach
                            @endif
                            @endif


                        </div>
                        @endif
                        <div id="sidebar11" class="d-none d-lg-block shadow-sm rounded px-1">
                            <div class=" bg-white rounded ">





                                <h4 class="h6 font-bold text-primary text-center mt-2">
                                    Filtrar por:
                                </h4>

                                <div class="accordion-item">
                                    <div class="d-flex align-items-center my-2">
                                        <i class="material-icons my-auto mr-2 text-info">grain</i>
                                        <span class="text-muted">Grado</span>
                                    </div>
                                    <div class="accordion-collapse px-2">
                                        @if (isset($degrees) && $degrees->count() > 0)
                                        @foreach ($degrees as $grade)
                                        <div class="form-check pt-2">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="{{ $grade->id}}" wire:model.live="gradeSelect">
                                                {{$grade->name}}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="accordion-item mt-5 pb-2">
                                    <div class="d-flex align-items-center my-2">
                                        <i class="material-icons my-auto mr-2 text-info">category</i>
                                        <span class="text-muted">Categoria</span>
                                    </div>
                                    <div class="accordion-collapse px-2">
                                        @if (isset($categories) && $categories->count() > 0)
                                        @foreach ($categories as $category)
                                        <div class="form-check pt-2">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" value="{{ $category->id}}" wire:model.live="categoriesSelect"> {{ $category->name}}
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                        @endforeach
                                        @endif
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