@extends('layouts.app',[
'title'=>'Membresias',
'navbarClass'=>'navbar-transparent',
'activePage'=>'memberships',

])
@section('content')
<div class="content  py-0 bg-white">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12 ">
                <h2 class="title text-center text-primary text-sm sm:text-2x1 md:text-2xl  lg:text-2xl border-bottom ">
                    {{ $membership->title }}
                    @role('admin')
                    <a class="btn btn-success btn-link p-0" href="{{ route('memberships.edit', $membership->id) }}" target="_blank">
                        <i class="material-icons">edit</i>
                    </a>
                    @endrole
                </h2>
            </div>
        </div>


        <!--row first-->
        <div class="row justify-content-around">
            <!--col left -->
            <div class="col-12 ">
                <div class="row">
                    <div class="col-12 mb-5">
                        <h2 class="title text-center text-primary text-sm sm:text-2x1 md:text-2xl  lg:text-2xl my-0">{{$membership->products->count()}} materiales incluidos </h2>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            @foreach ($membership->products as $product)
                            <div class="col-6 col-md-4 col-lg-2 mb-4" style="position: relative; padding:5px !important">
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
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection