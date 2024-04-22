@extends('errors.layout', [
'classPage' => 'error-page',
'activePage' => '500',
'pageBackground' => asset("material").'/img/bg-pricing.jpg',
'navbarClass'=>'text-white',
'title'=>'Mantenimiento'
])

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="col-md-12">
            <!-- <h1 class="title">Mantenimiento</h1> -->
            <h2 class="my-5">Estamos trabajando para brindarle un mejor servicio. </h2>
            <h4 class="mt-5">Regresa mas tarde :)</h4>
        </div>
     
    </div>
</div>
@endsection