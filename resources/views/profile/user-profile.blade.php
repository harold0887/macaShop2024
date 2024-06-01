@extends('layouts.app',[
'title'=>'Perfil',
'navbarClass'=>'navbar-transparent',
'activePage'=>'profile',
'menuParent'=>'profile'
])
@section('content')
<div class="content py-0 bg-white">
    <div class="row ">
        <div class="col-12">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb my-0 text-xs lg:text-base">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cuenta</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header card-header-icon card-header-primary">
                    <div class="card-icon">
                        <i class="material-icons">perm_identity</i>
                    </div>
                    <h4 class="card-title">{{ __('Edit Profile') }}
                    </h4>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="{{ route('profile.update') }}" autocomplete="off" class="form-horizontal">
                        @csrf
                        @method('put')

                        <div class="row">
                            <label class="col-sm-2 col-form-label">{{ __('Profile Photo') }}</label>
                            <div class="col-sm-7">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail img-circle">
                                        @if (auth()->user()->picture)
                                        <img src="{{ Storage::url(Auth::user()->picture) }}" alt="...">
                                        @else
                                        <img src="{{ asset('material') }}/img/placeholder.jpg" alt="...">
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                                    <div>
                                        <span class="btn btn-primary btn-file">
                                            <span class="fileinput-new">{{ __('Add Photo') }}</span>
                                            <span class="fileinput-exists">{{ __('Change') }}</span>
                                            <input type="file" name="photo" id="input-picture" />
                                        </span>
                                        <a href="#pablo" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> {{ __('Remove') }}</a>
                                    </div>
                                    @include('alerts.feedback', ['field' => 'photo'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                            <div class="col-sm-7">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}" required="true" aria-required="true" />
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                            <div class="col-sm-7">
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <input disabled class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required />
                                    @include('alerts.feedback', ['field' => 'email'])
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">{{ __('Save Changes') }}</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header card-header-icon card-header-primary">
                    <div class="card-icon">
                        <i class="material-icons">lock</i>
                    </div>
                    <h4 class="card-title">{{ __('Change password') }}</h4>
                </div>
                <div class="card-body">
                    <form id="update-profile-user" method="post" action="{{ route('profile.password') }}" class="form-horizontal">
                        @csrf
                        @method('put')

                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="input-current-password">{{ __('Current Password') }}</label>
                            <div class="col-sm-7">
                                <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                    <input class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" input type="password" name="old_password" id="input-current-password" placeholder="{{ __('Current Password') }}" value="" required />
                                    @include('alerts.feedback', ['field' => 'old_password'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="input-password">{{ __('New Password') }}</label>
                            <div class="col-sm-7">
                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="input-password" type="password" placeholder="{{ __('New Password') }}" value="" required />
                                    @include('alerts.feedback', ['field' => 'password'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="input-password-confirmation">{{ __('Password Confirmation') }}</label>
                            <div class="col-sm-7">
                                <div class="form-group">

                                    <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirm New Password') }}" value="" required />
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">{{ __('Change password') }}</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-12">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            @if(isset(auth()->user()->picture))
                            <img class="avatar border-gray" src="{{ Storage::url(Auth::user()->picture) }}" alt="...">
                            @else
                            <img src="{{ asset('material') }}/img/placeholder.jpg" alt="...">
                            @endif
                        </div>
                        <div class="card-body">
                            <h6 class="card-category text-gray">{{auth()->user()->name}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if(auth()->user()->email_verified_at == null)
                    <div class="card card-profile">
                        <div class="card-body">

                            <p class="card-description text-center my-4 text-sm  lg:text-base">
                                Su correo electrónico no ha sido verificado.
                            </p>
                            <p class="card-description text-center my-4 ">
                                Si no recibió el correo de verificación cuando se registró, por favor, haga clic en el botón de abajo para enviar un nuevo enlace de verificación a su correo electrónico.
                            </p>
                            <form class="text-center" method="POST" action="{{ route('verification.send') }}" id="resend-verified">
                                @csrf
                                <button type="submit" class="btn btn-primary">Enviar nuevo link</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

</div>
@endsection