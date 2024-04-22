@extends('errors.layout', [
'classPage' => 'error-page',
'activePage' => '404',
'pageBackground' => asset("material").'/img/bg-pricing.jpg',
'navbarClass'=>'text-white',
'title'=>'Error 404',
'background'=>''
])

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="col-md-12">
            <h1 class="title">404</h1>
            <h2>{{ __('Page not found') }} :(</h2>
            <h4>{{ __('Ooooups! Looks like you got lost') }}.</h4>
        </div>
        <div class="col-md-12 mt-5">
            <a href="{{ route('home') }}" class="text-white btn btn-rose btn-lg">
                <div class="d-flex align-items-center">
                    <i class="material-icons  mr-2 ">home</i>
                    <span class="fw-bold">Volver al inicio</span>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection