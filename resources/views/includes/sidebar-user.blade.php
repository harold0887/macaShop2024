<div class="sidebar" data-color="purple" data-background-color="black" data-image="{{ asset('material') }}/img/sidebar-2.jpg">
    <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
-->
    <div class="logo">
        <a href="{{route('home')}}" class="simple-text logo-mini">
            <i class="material-icons">home</i>
        </a>
        <a href="{{route('home')}}" class="simple-text logo-normal">
            inicio
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                @if (isset(auth()->user()->picture))
                <img src="{{ Storage::url(Auth::user()->picture) }}">
                @else
                <img class="avatar border-gray" src="{{ asset('img/No Profile Picture.png') }}" alt="...">
                @endif
            </div>
            <div class="user-info">
                <a data-toggle="collapse" href="#collapseExample" class="username">
                    <span>
                        @auth
                        @php
                        $name = explode(" ", Auth::user()->name);
                        echo $name[0];
                        @endphp
                        @endauth
                        <b class="caret"></b>
                    </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}">
                                <span class="sidebar-mini"> IR </span>
                                <span class="sidebar-normal"> Ir al inicio </span>
                            </a>
                        </li>

                        @auth
                        <li>
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <span class="sidebar-mini"> SA </span>
                                <span class="sidebar-normal"> Salir </span>
                            </a>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('profile.edit') }}">
                    <i class="material-icons">perm_identity</i>
                    <p>Perfil</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'orders' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('customer.orders') }}">
                    <i class="material-icons">shopping_bag</i>
                    <p>Mis Compras</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'products' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('customer.products') }}">
                    <i class="material-icons">view_list</i>
                    <p>Mis Productos</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'packages' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('customer.packages')}}">
                    <i class="material-icons">library_add</i>
                    <p>Mis Paquetes</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'memberships' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('customer.memberships') }}">
                    <i class="material-icons">card_membership</i>
                    <p>Mis Membresías</p>
                </a>
            </li>
            @role('admin')
            <li class="nav-item{{ $activePage == 'paselista' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('paselista.index') }}">
                    <i class="material-icons">checklist</i>
                    <p>Pase de lista</p>
                </a>
            </li>
            @endrole







        </ul>
    </div>
</div>