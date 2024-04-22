@include('includes.navbar')
@include('includes.borders')
<div class="wrapper wrapper-full-page ">


  @yield('content')
  @include('includes.alert-error')
</div>
@include('includes.borders')
@include('includes.footer')