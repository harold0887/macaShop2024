@extends('layouts.app',[
'title'=>'Categorias',
'navbarClass'=>'navbar-transparent',
'activePage'=>'categories',
])
@section('content')


<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">category</i>
                        </div>
                        <h4 class="card-title">Agregar categoria</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="name">Nombre de categoria</label>
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