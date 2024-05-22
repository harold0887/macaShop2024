@extends('layouts.app',[
'title'=>'Usuarios',
'navbarClass'=>'navbar-transparent',
'activePage'=>'users',
])
@section('content')

<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">people</i>
                        </div>
                        <h4 class="card-title">Editar - {{ $user->name }}
                            <h4>

                    </div>
                    <div class="card-body ">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label class="bmd-label-floating" for="name">Nombre de usuario</label>
                                    <input type="text" class="form-control" name="name" required value="{{ $user->name }}" disabled>
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="bmd-label-floating" for="email">Email</label>
                                    <input type="email" class="form-control" name="email" required value="{{ $user->email }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label class="bmd-label-floating" for="whatsapp">WhatsApp</label>
                                    <input type="whatsapp" class="form-control" name="whatsapp" value="{{ $user->whatsapp }}">
                                    @error('whatsapp')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="bmd-label-floating" for="facebook">Facebook</label>
                                    <input type="facebook" class="form-control" name="facebook" value="{{ $user->facebook }}">
                                    @error('facebook')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <select name="roles[]" class="selectpicker form-control" data-size="7" data-style="select-with-transition " multiple title="Roles...">





                                        @foreach ($roles as $role)
                                        <option value=" {{ $role->name }}" @foreach($user->roles as $rolUser)
                                            @if($rolUser->id == $role->id)
                                            selected
                                            @endif
                                            @endforeach
                                            {{ (collect(old('roles'))->contains($role->id)) ? 'selected':'' }}>
                                            {{ $role->name }}
                                        </option>
                                        @endforeach

                                    </select>
                                    @error('roles')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row mt-lg-5">

                                <div class="form-group col-md-12">
                                    <label class="bmd-label-floating" for="comment">Comentarios</label>
                                    <textarea class="form-control border rounded mt-2" name="comment" rows="5" value="">{{ old('comment') ?: $user->comment }}</textarea>
                                    @error('comment')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
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