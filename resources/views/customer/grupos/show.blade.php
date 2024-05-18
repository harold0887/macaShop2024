@extends('layouts.app',[
'title'=>'Pase de lista',
'navbarClass'=>'navbar-transparent',
'activePage'=>'paselista',
'menuParent'=>'orders',
])
@section('content')
<livewire:customer.show-grupos />
@endsection