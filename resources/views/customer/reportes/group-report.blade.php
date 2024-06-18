@extends('layouts.app',[
'title'=>$group->grado_grupo." - ".$group->escuela,
'navbarClass'=>'navbar-transparent',
'activePage'=>'paselista',
'menuParent'=>'orders',
])
@section('content')


<livewire:customer.group-report-render />






@endsection