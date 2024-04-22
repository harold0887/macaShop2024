<div class="container bg-white shadow my-1 rounded ">
    @include('includes.spinner-livewire')
    <div class="content-main">
        <div class="row">
            <div class="col-12 ">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0 text-xs lg:text-base">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Tienda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Paquetes</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h1 class="lg:pt-5 pt-4 md:text-3xl  text-center  text-xl text-muted">Ya contamos con <span class="fw-bold text-primary">paquetes de cuadenillos</span></h1>
                <p class="text-center mx-2 text-justify">Adquiere tu primer paquete de cuadenillos y
                    <span class="text-primary">ahorra.</span>
                </p>
            </div>
        </div>
        <!--row Packages-->
        <div class="row  justify-content-center mt-5">
            @if (isset($packages) && $packages->count() > 0)
            @foreach ($packages as $package)
            <div class="col-10 col-md-4 col-lg-3 " style="position: relative; padding:5px !important">
                <div class="  card card-primary card-product">

                    <div class="card-header card-header-image" data-header-animation="true">
                        <a href="{{route('paquete.show',$package->slug)}}">
                            <img class="img" src="{{ Storage::url($package->itemMain) }} ">
                        </a>
                    </div>
                    <div class="card-body   px-1">
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
                        <h3 class="card-title   text-base my-2">
                            <a href="{{route('paquete.show',$package->slug)}}"><span class="text-base">{{ $package->title }}</span></a>
                        </h3>
                        <div class="card-description">
                            @if ($package->price > $package->discount_percentage)
                            <span class="text-2xl  my-3 text-center d-block">
                                Antes: <span style="text-decoration:line-through;">${{ round($package->price) }}</span>
                                <span class="text-xs">
                                    MXN
                                </span>
                            </span>
                            @endif
                            <span class="text-center fw-bold h1  text-muted">
                                {{ round($package->price_with_discount) }}.00
                            </span>
                            <span class="text-sm">
                                MXN
                            </span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href=" {{route('paquete.show',$package->slug)}} " class="btn   btn-link text-primary">
                            Ver materiales didácticos incluidos
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-12 d-flex justify-content-center">
                {{ $packages->links() }}
            </div>
            @else
            <div class="col-12 text-center">
                <p class="alert alert-warning ">⚠️ !Oops! No se encontraron resultados, intente cambiar los filtros o la busqueda.</p>
            </div>
            @endif
        </div>
        <!--end row Packages-->
    </div>
</div>