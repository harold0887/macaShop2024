<nav id="{{$navbarClass}}" class="navbar fixed-top sticky-lg-top navbar-expand-lg {{$navbarClass}} navbar-transparent  mb-0" style="background-color: {{$background}} ;  ">


  <div class="container-fluid">

    @if(Request::route()->getName() =='home')
    <div class="d-block d-lg-none" style="width: 80% !important;">
      <div class="search-panels">
        <div class="search-group">
          <input id="input-search-home" required="" type="text" name="text" autocomplete="on" class="input">
          <label class="enter-label">Buscar</label>
          <div class="btn-box">

          </div>
          <div class="btn-box-x">
            <button class="btn-cleare">
              <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512">
                <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" id="cleare-line"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>



    </div>
    <div class="navbar-wrapper d-none d-lg-block px-0 mx-0">
      <a class="navbar-brand px-0 mx-0" style="padding: 0px !important">

        <a class="navbar-brand py-0" href="{{route('home')}}" style="font-family: 'Fredericka the Great'"><img class="logo-main" src=" {{ asset('./img/logo3.png') }} " alt=""></a>
      </a>
    </div>

    @else
    <div class="navbar-wrapper  px-0">
      <a class="navbar-brand  mx-0 p-0" href="{{ route('home') }}">
        <img class="logo-main" src=" {{ asset('./img/logo3.png') }} " alt="">
      </a>
    </div>
    @endif




    <button class="navbar-toggler " type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="sr-only ">Toggle navigation</span>
      <span class="navbar-toggler-icon icon-bar text-danger bg-danger"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center">

      <ul class="navbar-nav">
        <li class="nav-item{{ $activePage == 'home' ? ' active' : '' }}">
          <a href="{{ route('home') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">home</i><span class="fw-bold">Inicio</span>
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'shop' ? ' active' : '' }}">
          <a href="{{ route('shop.index') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">shopping_bag</i><span class="fw-bold">Tienda</span>

          </a>
        </li>
        <li class="nav-item{{ $activePage == 'package' ? ' active' : '' }} position-relative">
          <a href="{{ route('paquete') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">library_add</i><span class="fw-bold">Paquetes</span>
          </a>

        </li>
        <li class="nav-item{{ $activePage == 'membership' ? ' active' : '' }}">
          <a href="{{ route('membership') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">card_membership</i><span class="fw-bold">Membresía vip</span>

          </a>
        </li>
        <!-- <li class="nav-item{{ $activePage == 'free' ? ' active' : '' }}">
          <a href="{{ route('free') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">crop_free</i><span class="fw-bold">Gratuito</span>

          </a>
        </li> -->
        @role('admin')
        <li class="nav-item{{ $activePage == 'asistencia' ? ' active' : '' }}">
          <a href="{{ route('asistencia.demo') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">checklist</i> <span class="fw-bold">asistencia y evaluaciones</span>
          </a>
        </li>
        <!-- <li class="nav-item{{ $activePage == 'asitencia' ? ' active' : '' }}">
          <a href="{{ route('login') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">donut_large</i> <span class="fw-bold">Evaluaciones</span>
          </a>
        </li> -->
        @endrole
        @guest
        <li class="nav-item{{ $activePage == 'register' ? ' active' : '' }}">
          <a href="{{ route('register') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">person_add</i> <span class="fw-bold">{{ __('Register') }}</span>
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'login' ? ' active' : '' }}">
          <a href="{{ route('login') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">fingerprint</i> <span class="fw-bold">{{ __('Login') }}</span>
          </a>
        </li>
        @endguest




        @role('admin')



        <li class="nav-item {{ $activePage == 'dashboard' ? ' active' : '' }}">
          <a href="{{ route('dashboard') }}" class="nav-link text-primary">
            <i class="material-icons">dashboard</i> <span class="fw-bold">dashboard</span>
          </a>
        </li>
        @endrole

        @auth
        <li class="nav-item dropdown {{ $activePage == 'profile' ? ' active' : '' }}">
          <a class="nav-link text-primary dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">person</i>
            @php
            $name = explode(" ", Auth::user()->name);
            echo $name[0];
            @endphp
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background:#e9e9e8;">

            <a class="dropdown-item" href="{{route('profile.edit')}}">{{ __('My Profile') }}</a>
            <a class="dropdown-item" href="{{route('customer.orders')}}">Mis compras</a>
            <a class="dropdown-item" href="{{ route('customer.memberships') }}">Mis Membresías</a>
            @role('admin')
            <a class="dropdown-item" href="{{ route('grupos.index') }}">Registro de asistencia</a>
            <a class="dropdown-item" href="{{ route('grupos.index') }}">Evaluaciones</a>


            @endrole
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault();
                                      this.closest('form').submit();">Salir</a>
            </form>
          </div>
        </li>
        @endauth


        <li class="nav-item{{ $activePage == 'cart' ? ' active' : '' }}">
          <a href="{{ route('cart.index') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">shopping_cart</i><span class="fw-bold">Carrito</span>
            <span class="badge rounded-pill badge-notification" style="position: absolute; top:0; left:-10px">
              <livewire:cart-count />
            </span>
          </a>
        </li>



      </ul>
    </div>

  </div>

</nav>