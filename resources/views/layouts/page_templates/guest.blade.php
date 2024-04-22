@include('includes.navbar')
<div class="wrapper wrapper-full-page">
    <div class="page-header {{ $classPage }} header-filter" filter-color="black" style="background-image: url('{{ $pageBackground }}'); background-size: cover; background-position: top center;align-items: center;">

    @yield('content')

  </div>
</div>
