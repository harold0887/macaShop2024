<div class="wrapper ">
  @include('includes.sidebar')
  <div class="main-panel">
    @include('includes.navbar-admin')
    @yield('content')
    @include('includes.alert-error')
  </div>
</div>