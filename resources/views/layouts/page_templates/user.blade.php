<div class="wrapper ">
  @include('includes.sidebar-user')
  <div class="main-panel">
    @include('includes.navbar-user')
    @yield('content')
    @include('includes.alert-error')
  </div>
</div>