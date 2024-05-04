<div class="container bg-white shadow my-1 rounded">
    @include('includes.spinner-livewire')
    <div class="content-main">
        <div class="row ">
            <div class="col-12">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0 text-xs lg:text-base">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Tienda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Membresías</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if (isset($memberships) && $memberships->count() > 0)
        <div class="row">
            <div class="col-12">
                <h1 class=" lg:pt-5 pt-4 md:text-3xl  text-center  text-xl text-muted">
                    <span class="fw-bold text-primary">Membresía preescolar y Membresía primaria</span>
                    se convertirán en tu mejor aliado.
                </h1>
                <p class="text-left text-lg-center mx-2 ">Estás a un paso de acceder a más de 50 materiales en cada una de nuestras membresías!!!</p>
            </div>
        </div>
        <div class="row  mt-3">
            <div class="col-6 col-lg-3 d-flex   align-items-center  py-0">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg  ">Material de REFUERZO. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Ev. Diagnostica. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Banner’s. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Material visual para el aula. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Juegos didácticos. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Agenda personalizada. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Diario de la educadora. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Y MUCHO MÁS!!!📚. </span>
            </div>
        </div>

        <div class="row justify-content-center px-lg-5">
            @foreach ($memberships as $membership)
            <div class="col-11 col-md-4 col-lg-4 px-lg-5 mb-4 {{($membership->discount_percentage < $membership->price) ? 'order-first order-lg-0' : '' }}" style="position: relative">
                <div class=" animate__animated  animate__shakeX animate__repeat-1	   card card-primary card-product {{($membership->discount_percentage < $membership->price) ? 'border  border-primary' : 'border' }}" style=" overflow: hidden;">
                    @if($membership->start > now())
                    <div class="price-label bg-primary animate__animated  animate__flash animate__infinite 	infinite"><span>Preventa</span></div>
                    @else
                    @if($membership->price > $membership->price_with_discount)
                    <div class="price-label bg-primary animate__animated  animate__flash animate__infinite 	infinite"><span>Oferta</span></div>
                    @endif
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
                        <a href=" {{route('membership.show',$membership->slug)}} " class="btn   btn-link text-primary">
                            Ver materiales didácticos incluidos
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="col-12 text-center text-sm md:text-base ld:text-base">
                <span class="text-danger">Importante:</span>
                <span class=" text-muted"> La membresía no incluyen todo el material didáctico de la TIENDA.</span>
            </div>
        </div>
        @else
        <div class="col-12 lg:pt-5 pt-4 md:text-3xl  text-center  text-xl text-muted my-5 py-5">
            <span>Por ahora no hay membresias disponibles. Regresa pronto...</span>
        </div>
        @endif

    </div>
</div>