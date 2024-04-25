@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'profile',
'title' =>"Inicio",
'pageBackground' => asset("material").'/img/login.jpg',
'navbarClass'=>'text-primary',
'background'=>'#eee !important'
])

@section('content')
<div class="container ">
  <div class="content-main ">
    <div class="row justify-content-center mt-5">
      <div class="col-lg-7 col-md-8">
        <div class="card card-login card-hidden mb-3">
          <div class="card-header card-header-primary text-center">
            <p class="card-title"><strong>{{ __('Verify Your Email Address') }}</strong></p>
          </div>
          <div class="card-body">
            <p class="card-description text-center my-4 text-sm  lg:text-base">
              Antes de continuar, compruebe el enlace de verificación enviado a su correo electrónico
              <span class="fw-bold">{{Auth::user()->email}}</span>
            </p>
            <p class="card-description text-center my-4 ">
              Si no ha recibido el correo, por favor, haga clic en el botón de abajo para enviar un nuevo enlace de verificación a su correo electrónico.
            </p>

            <form class="text-center" method="POST" action="{{ route('verification.send') }}" id="resend-verified">
              @csrf
              <button type="submit" class="btn btn-primary  btn-round ">Enviar nuevo link</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('js')
<script>
  $(document).ready(function() {
    @if(session('resent'))
    $.notify({
      icon: "done",
      message: "{{ __('A fresh verification link has been sent to your email address.') }}"
    }, {
      type: 'success',
      timer: 3000,
      placement: {
        from: 'top',
        align: 'right'
      }
    });
    @endif

    md.checkFullPageBackgroundImage();
    setTimeout(function() {
      // after 1000 ms we add the class animated to the login/register card
      $('.card').removeClass('card-hidden');
    }, 700);
  });
</script>
@endpush