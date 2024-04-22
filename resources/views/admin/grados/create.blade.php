@extends('layouts.app',[
'title'=>'Grados',
'navbarClass'=>'navbar-transparent',
'activePage'=>'grados',
])
@section('content')
<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">grain</i>
                        </div>
                        <h4 class="card-title">Agregar Grado</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('degrees.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label class="bmd-label-floating" for="name">Nombre del grado</label>
                                    <input type="text" class="form-control" name="name" required>
                                    @error('name')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-10  mt-5">
                                <button type="submit" class="btn btn-primary">Guardar</button>
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