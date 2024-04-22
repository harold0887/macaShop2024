@extends('layouts.app',[
'title'=>'Ventas',
'navbarClass'=>'navbar-transparent',
'activePage'=>'sales',
])
@section('content')

<livewire:admin.show-sales />


@endsection
