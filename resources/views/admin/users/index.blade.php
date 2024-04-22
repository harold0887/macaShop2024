@extends('layouts.app',[
'title'=>'Usuarios',
'navbarClass'=>'navbar-transparent',
'activePage'=>'users',
])
@section('content')

<livewire:admin.index-users />


@endsection