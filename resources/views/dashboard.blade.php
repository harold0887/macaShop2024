@extends('layouts.app', ['activePage' => 'dashboard',
'menuParent' => 'dashboard',
'title' => __('Dashboard'),
'navbarClass'=>'text-primary'
])


@section('content')
@include('includes.settings')


@livewire('dashboard-render')




@endsection