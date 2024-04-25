@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'login',
'title' => 'Restablecer contraseña',
'pageBackground' => asset("material").'/img/bg-pricing.jpg',
'navbarClass'=>'text-primary',
'background'=>'#eee !important'
])

@section('content')
<div class="container">
  <div class="row align-items-center">
    <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
      <form id="forgot-password" class="form" method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="card card-login card-hidden mb-3">
        <div class="card-header card-header-primary d-flex align-items-center justify-content-center ">
            <span class="material-symbols-outlined mr-2">
              passkey
            </span>
            <h4 class="card-title"><strong>{{ __('Reset Password') }}</strong></h4>
          </div>
  
          <div class="card-body">
            <div class="text-center">
              <span class="text-muted">Ingresa tu correo electrónico para recibir un link y reestablecer tu contarseña.</span>
            </div>
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="Ingresa tu email" value="{{ old('email') }}" required>
              </div>
              @if ($errors->has('email'))
              <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                <strong>{{ $errors->first('email') }}</strong>
              </div>
              @endif
            </div>
          </div>
          <div class="card-footer justify-content-center">
            <button type="submit" class="btn btn-primary  btn-round mt-4 btn-lg">{{ __('Send Password Reset Link') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@include('includes.alert-error')
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