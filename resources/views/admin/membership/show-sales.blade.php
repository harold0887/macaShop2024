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
                <h2 class="title text-center text-primary text-sm sm:text-2x1 md:text-2xl  lg:text-2xl border-bottom  mb-0">
                    {{ $membership->title }}
                    @role('admin')
                    <a class="btn btn-success btn-link p-0" href="{{ route('memberships.edit', $membership->id) }}" target="_blank">
                        <i class="material-icons">edit</i>
                    </a>
                    @endrole
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <livewire:admin.show-membership />
            </div>
        </div>


    </div>
</div>
@endsection