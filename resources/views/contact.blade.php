@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => '',
'title' =>"Contacto",
'pageBackground' => asset("material").'/img/login.jpg',
'navbarClass'=>'text-primary',
'background'=>'#eee !important'
])

@section('content')

<div class="container ">
    <div class="content py-0 bg-white">

        <div class="row my-5 pb-5 justify-content-center">
            <div class="col-12   text-center">
                <h2 class="font-serif lg:text-2xl lg:pt-12 md:text-3xl md:font-bold text-center text-2xl text-primary mb-3">
                    Contáctanos en WhatsApp
                </h2>
                <a href="https://wa.me/message/GUNXZZ666PN3I1" target="_blank">

                    <span class="d-inline">
                        <p class="text-center text-muted text-gray-1000 mt-0 text-base md:text-base">
                            Envianos un mensaje, solo da click en el logo de WhatsApp
                        </p>
                    </span>
                    <img class="d-inline" src="{{ asset('img/whatsapp.png') }} " width="60">
                </a>

            </div>
        </div>

    </div>
</div>


@endsection