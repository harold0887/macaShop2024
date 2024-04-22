<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon.png">
  <link rel="icon" type="image/png" href="/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>{{ $title.' | Material Didáctico MaCa' ?? 'Material Didáctico Maca' }}</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />

  @vite(['resources/css/app.scss'])

</head>

<body class="off-canvas-sidebar">

  <div class="wrapper wrapper-full-page">
    <div class="page-header {{ $classPage }} header-filter" filter-color="black" style="background-image: url('{{ $pageBackground }}'); background-size: cover; background-position: top center;align-items: center;">

      @yield('content')

    </div>
  </div>



</body>

</html>