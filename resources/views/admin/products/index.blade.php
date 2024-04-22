@extends('layouts.app',[
'title'=>'Productos',
'navbarClass'=>'navbar-transparent',
'activePage'=>'products',
])
@section('content')
<livewire:admin.index-products />
@endsection