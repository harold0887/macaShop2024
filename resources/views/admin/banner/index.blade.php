@extends('layouts.app',[
'title'=>'Banners',
'navbarClass'=>'navbar-transparent',
'activePage'=>'banners',
])
@section('content')
<livewire:admin.index-banners />
@endsection