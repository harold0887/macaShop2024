@extends('layouts.app',[
'title'=>'Registro de asistencia',
'navbarClass'=>'navbar-transparent',
'activePage'=>'paselista',
'menuParent'=>'orders',
])
@section('content')
<livewire:customer.show-grupos />
@endsection