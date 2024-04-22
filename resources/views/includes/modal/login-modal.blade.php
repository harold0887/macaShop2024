<div class="modal fade" id="loginModal" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" id="btn-login-close"></button>
            </div>
            <div class="modal-body">
                <form class="form" method="POST" action="{{ route('login') }}" id="loginForm1">
                    @csrf
                    <div class="card card-login card-primary card-hidden mb-3">
                        <div class="card-header card-header-primary d-flex align-items-center justify-content-center ">
                            <i class="material-icons mr-2">fingerprint</i>
                            <h4 class="card-title"><strong>Ingresa con tu email</strong></h4>
                        </div>

                        <div class="card-body pt-5">

                            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">email</i>
                                        </span>
                                    </div>
                                    <input id="login-email" type="email" placeholder="Correo electrónico" name="email" class="form-control" required>
                                </div>
                                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                                    <span class="error text-danger"></span>
                                </div>
                            </div>
                            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} ">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input id="login-password" type="password" placeholder="Contraseña" name="password" class="form-control">
                                </div>
                                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                                    <span class="error text-danger"></span>
                                </div>
                            </div>
                            <div class="form-check mr-auto ml-3 mt-3 ">
                                <label class="form-check-label">
                                    <input id="login-remember" class="form-check-input" type="checkbox" name="remember" checked>
                                    {{ __('Remember me') }}
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="card-footer justify-content-center">
                            <button type="submit" class="btn btn-primary  btn-round mt-4 btn-lg" id="btn-login-modal">
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
                    </div>

                </form>
                <div class="row">
                    <div class="col-12">

                    <a href="{{ route('password.request') }}" style="text-decoration: none !important;">
                        <small class="text-muted fw-bold" >{{ __('Forgot password') }} ?</small>
                    </a>

                    </div>
                    <div class="col-6 text-right">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>