@extends('layouts.app',[
'title'=>'Categorias',
'navbarClass'=>'navbar-transparent',
'activePage'=>'categories',
])
@section('content')


<div class="content py-0 bg-white">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">category</i>
                        </div>
                        <h4 class="card-title">Editar</h4>
                    </div>
                    <div class="card-body ">
                        <form action="{{ route('category.update', $category->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="name">Nombre de categoria</label>
                                    <input type="text" class="form-control" name="name" required value="{{ $category->name }}">
                                    @error('name')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-10  mt-5">
                                <button type="submit" class="btn btn-primary">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons mr-1">autorenew</i>Actualizar
                                    </div>
                                </button>
                                <a class="btn btn-outline-primary " href="{{ route('category.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons mr-1">undo</i>Regresar
                                    </div>
                                </a>
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