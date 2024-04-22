@extends('layouts.app',[
'title'=>'Ventas',
'navbarClass'=>'navbar-transparent',
'activePage'=>'sales',
])
@section('content')
<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">receipt</i>
                        </div>
                        <h4 class="card-title">Agregar venta</h4>
                    </div>
                    <div class="card-body ">
                        <form action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <label for="order">Order MP</label>
                                    <input type="number" class="form-control" name="order" value="{{ old('order') }}" step="0.01">
                                    @error('order')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="price">Precio</label>
                                    <input type="number" class="form-control" name="price" value="{{ old('price') }}" step="0.01">
                                    @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>



                            </div>
                            <div class="form-row">

                                <div class="form-group col-12 col-md-4 ">
                                    <select id="create-sales-users" name="user" class="form-control">
                                        <option selected disabled value="">Selecciona...</option>
                                        @if (isset($users) && $users->count() > 0)
                                        @foreach ($users as $user)
                                        <option value=" {{ $user->id }}" {{ old('user') == $user->id ? 'selected' : '' }}>
                                            {{ $user->id }} - {{ $user->name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('user')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>






                            </div>


                            <div class="col-sm-10 text-center mt-5">
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