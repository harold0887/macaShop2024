@extends('layouts.app',[
'title'=>'Grados',
'navbarClass'=>'navbar-transparent',
'activePage'=>'grados',
])
@section('content')
<div class="content py-0 bg-white">

    <div class="container-fluid">

        <div class="row ">
        <div class="col-12">
            <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">grain</i>
                    </div>
                    <h4 class="card-title">Editar - {{ $grade->name }}</h4>
                </div>
                <div class="card-body ">
                    <form action="{{ route('degrees.update', $grade->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="name">Nombre del grado</label>
                                <input type="text" class="form-control" name="name" required value="{{ $grade->name }}">
                            </div>
                        </div>
                        <div class="col-sm-10  mt-5">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <button type="reset" class="btn">Cancelar</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>


        </div>
    </div>
</div>
@endsection
@include('includes.alert-error')