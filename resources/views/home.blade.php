@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'home',
'title' =>"Inicio",
'pageBackground' => asset("material").'/img/login.jpg',
'navbarClass'=>'text-primary ',
'background'=>'#eee !important'
])

@section('content')
<div class="container bg-white shadow my-1 rounded">
    <div class="content-main ">
        <div class="d-block d-lg-none">
            <div class="row">
                <div class="col-4 d-flex align-items-center  ">
                    <img class="w-100" src=" {{ asset('./img/logo3.png') }} " alt="">
                </div>
                <div class="col-8 ">
                    <div class="row text-center">
                        <div class="col-12 px-1">
                            <a href=" {{ route('membership') }}" class="btn btn-round btn-info w-100 ">
                                Membresia VIP
                            </a>
                        </div>
                        <div class="col-6 px-1">
                            <a href="{{route('shop.index')}}" class="btn  btn-round btn-primary w-100 px-0">
                                Tienda
                            </a>
                        </div>
                        <div class="col-6 px-1">
                            <a href="{{ route('free') }}" class="btn btn-round btn-warning w-100 px-0">
                                Gratuitos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none d-lg-block">
            <div class="row  justify-content-center">
                <div class="col-10 col-md-6">
                    <div class="search-panels">
                        <div class="search-group">
                            <input id="input-search-home1" required="" type="text" name="text" autocomplete="on" class="input ">
                            <label class="enter-label">Buscar</label>
                            <div class="btn-box">

                            </div>
                            <div class="btn-box-x">
                                <button class="btn-cleare">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                                        <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" id="cleare-line"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <span class="text-danger text-xs position-absolute w-100 bg-white p-2 rounded d-none" id="null-search1" style="z-index: 500;"></span>


                </div>

            </div>


        </div>




        <div class="row ">
            <div class="col-12 rounded  px-0">
                <div class="">
                    @if(isset($newsDesktop) && $newsDesktop->items->count() >0)
                    <div id="carouselDesktop" class="carousel slide carousel-fade" data-mdb-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach($newsDesktop->items as $item)
                            <button class=" bg-primary @if ($loop->first) active  @endif" data-mdb-target="#carouselDesktop" data-mdb-slide-to="{{ $loop->index }}" aria-label="Slide {{ $loop->index+1 }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach($newsDesktop->items as $item)
                            <div class="carousel-item   @if ($loop->first) active  @endif  ">
                                <img class=" w-100 d-block shadow" src="{{ Storage::url($item->photo) }}" alt="">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>


            </div>
        </div>
        <div class="row justify-content-between mt-0 mb-lg-4">

            <div class="col-6 col-md-3 p-1 text-center">
                <a href="{{route('shop.index')}}">
                    <div class="rounded bg-primary">
                        <img class="w-100" src="{{asset('img/tienda.png')}}" alt="">
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 p-1 text-center">
                <a href="{{route('membership')}}">
                    <div class="rounded bg-info position-relative" style=" overflow: hidden !important;">
                    <div class="price-label bg-primary animate__animated  animate__flash animate__infinite 	infinite"><span>Preventa</span></div>
                        <img class="w-100 rounded" src="{{asset('img/preescolar_preventa.png')}}" alt="">
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 p-1 text-center">

                <a href="{{route('membership')}}">
                    <div class="rounded bg-warning position-relative" style=" overflow: hidden !important;">
                        <div class="price-label bg-primary animate__animated  animate__flash animate__infinite 	infinite"><span>Preventa</span></div>
                        <img class="w-100 rounded" src="{{asset('img/primaria_preventa.png')}}" alt="">
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 p-1 text-center">
                <a href="{{route('free')}}">
                    <div class="rounded">
                        <img class="rounded  w-100 bg-light" src="{{asset('img/free.png')}}" alt="">
                    </div>
                </a>
            </div>
        </div>
        <livewire:novedades />
        <livewire:best-seler />

        <div class="row mt-3">

            <div class="col-12">
                <h1 class=" lg:pt-5 md:text-3xl  text-center  text-xl text-muted">La mejor opción para <span class="fw-bold text-primary">personas que enseñan desde el corazón.</span></h1>
                <p class="text-center mx-2 text-justify">¿Buscas material didáctico o material para decorar el aula? en
                    <span class="text-primary">Material didáctico MaCa
                        <span class="animate__animated  animate__pulse animate__infinite 	infinite	 ">💖</span>
                    </span> tenemos algo para ti.
                </p>
                <div class="row mt-5">
                    <div class="col-12 col-lg-6  pr-4 align-self-center ">
                        <div class="row ">
                            <div class="col-auto">
                                <div class="rounded p-3 box-target">
                                    <span class="material-symbols-outlined animate__animated  animate__pulse animate__infinite 	infinit  text-primary">
                                        kid_star
                                    </span>
                                </div>

                            </div>
                            <div class="col text-muted">
                                <p class="fw-bold my-0">Contenido de gran calidad</p>
                                <p class="text-sm   lg:text-base  text-muted">Descarga materiales didácticos con el mejor diseño e imágenes de gran calidad que llamarán la atención de los peques.</p>
                            </div>
                        </div>
                        <div class="row mt-2 mt-lg-5">
                            <div class="col-auto">
                                <div class="rounded p-3 box-target">
                                    <span class="material-symbols-outlined animate__animated  animate__pulse animate__infinite 	infinite	 text-primary">
                                        card_membership
                                    </span>
                                </div>

                            </div>
                            <div class="col text-muted">
                                <p class="fw-bold my-0">Acceso a nuestras membresías</p>
                                <p class="text-sm   lg:text-base  text-muted">¡Disfruta más de 100 materiales en nuestras membresías!
                                    <strong class="text-primary">Membresía preescolar</strong> y
                                    <strong class="text-primary">Membresía primaria</strong>, se
                                    convertirán en tu
                                    <strong class="text-primary">
                                        mejor aliado.
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="row mt-2 mt-lg-5">
                            <div class="col-auto">
                                <div class="rounded p-3 box-target">
                                    <span class="material-symbols-outlined animate__animated  animate__pulse animate__infinite 	infinite text-primary">
                                        search
                                    </span>


                                </div>

                            </div>
                            <div class="col text-muted">
                                <p class="fw-bold my-0">Recursos actualizados</p>
                                <p cclass="text-sm   lg:text-base  text-muted">Mejoramos constantemente para ofrecerte un catálogo actualizado de nuestros materiales didácticos.</p>
                            </div>
                        </div>

                        <div class="row my-2 mt-lg-5">
                            <div class="col-auto">
                                <div class="rounded p-3 box-target">
                                    <span class="material-symbols-outlined animate__animated  animate__pulse animate__infinite 	infinite text-primary">
                                        check_circle
                                    </span>
                                </div>

                            </div>
                            <div class="col text-muted">
                                <p class="fw-bold my-0">Descarga inmediata</p>
                                <p class="text-sm   lg:text-base  text-muted">Los recursos comprados se pueden descargar inmediatamente desde su cuenta.</p>
                            </div>
                        </div>




                    </div>
                    <div class="col-12 col-lg-6">
                        <img class="img-maestra" alt="" src="{{asset('img/maestra.jpg')}}">
                    </div>
                </div>
            </div>
        </div>





        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h2 class="pt-5  md:text-3xl  text-center  text-2xl text-muted">
                        ¿Aún no estás convencid@?
                    </h2>

                    <p class="mx-2 text-muted">
                        Mira lo que lo que piensan los clientes de nuestros materiales didácticos.

                    </p>

                </div>
            </div>
        </div>


        <div>
            <div id="comments-slick" class="coments-autoplay" style="display: show">
                @if (isset($comments) && $comments->count() > 0)
                @foreach ($comments as $comment)
                <div class="px-5 px-lg-2  ">
                    <div class="card card-testimonial " @if( $loop->index%2 != 0) style="border: solid 2px #A578DA; border-radius: 5px 5px 70px 5px !important" @else style="border: solid 2px #52CFDD; border-radius: 5px 5px 70px 5px !important" @endif ">

                        <div class="card-body ">
                            <h5 class="card-description text-sm" style="height: 100px;">
                                {{Str::limit($comment->comment,200)}}
                            </h5>
                        </div>
                        <div class="card-footer">

                            <h5 class="card-title fw-bold text-primary">
                                @php
                                $name = explode(" ", $comment->user->name);
                                echo $name[0];
                                @endphp
                            </h5>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
















    </div>
</div>






@endsection

@push('js')
<script>
    $("#input-search-home,#input-search-home1").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('search.products')}}",
                dataType: 'json',
                data: {
                    term: request.term
                },
                success: function(data) {

                    response(data)
                    if (!data.length > 0) {
                        $("#null-search1, #null-search").removeClass("d-none")
                        $("#null-search1, #null-search").addClass("d-block")
                        $("#null-search1, #null-search").text("⚠️ !Oops! No se encontraron resultados, intente cambiar la busqueda.");
                    }

                },



            })
        },
        select: function(event, ui) {
            window.location.href = "https://materialdidacticomaca.com/tienda/productos/" + ui.item.value
        },

    })
</script>



@endpush