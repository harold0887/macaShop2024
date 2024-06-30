@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'login',
'title' => __('Login'),
'pageBackground' => asset("material").'/img/markus-spiske-187777.jpg',
'navbarClass'=>'text-primary',
'background'=>'#eee !important'
])

@section('content')
<div class="container" style="padding-top: 0 !important;">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="card card-login card-primary card-hidden mb-3 ">
                    <div class="card-header card-header-primary d-flex align-items-center justify-content-center ">
                        <i class="material-icons mr-2">fingerprint</i>
                        <h4 class="card-title"><strong>Ingresa con tu email</strong></h4>
                    </div>

                    <div class="card-body">
                        <span class="form-group  bmd-form-group email-error {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">email</i>
                                    </span>
                                </div>
                                <input type="email" class="form-control err-email" id="exampleEmails" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                        </span>
                        <span class="form-group bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" id="examplePassword" name="password" placeholder="Contraseña" required>
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                        </span>
                        <div class="form-check mr-auto ml-3 mt-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : 'checked' }}> {{ __('Remember me') }}
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit" class="btn btn-primary  btn-round mt-4 btn-lg">
                            Ingresar
                        </button>
                    </div>
                    <div class="card-footer justify-content-center">
                        <span class="card-description mx-3">¿No tienes cuenta? </span>
                        <a href="{{ route('register') }}" class="nav-link  text-primary">
                            <div class="d-flex align-items-center">
                                <i class="material-icons mr-1">person_add</i>
                                <span>Crea una cuenta gratis</span>
                            </div>
                        </a>
                    </div>
                    <div class="row px-3">
                        <div class="col-12 text-center my-2 border-top">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                <small class="text-muted fw-bold text-muted">{{ __('Forgot password') }} ? click aqui.</small>
                            </a>
                            @endif
                        </div>
                    </div>


                </div>

            </form>
        </div>
    </div>
</div>

@endsection
@if (session('status'))
@push('js')
<script>
    $.notify({
        icon: "check_circle",
        message: "{{session('status')}}",
    }, {
        type: "success",
        timer: 3000,
        placement: {
            from: "top",
            align: "right",
        },
    });
</script>
@endpush
@endif

@push('js')
<script>
    $(document).ready(function() {
        md.checkFullPageBackgroundImage();
        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700);
    });
</script>


@endpush