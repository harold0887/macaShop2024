@extends('layouts.app',[
'title'=>'Membresias',
'navbarClass'=>'navbar-transparent',
'activePage'=>'memberships',
])
@section('content')

<livewire:admin.index-memberships />


@endsection