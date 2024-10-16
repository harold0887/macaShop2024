<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="apple-touch-icon" sizes="76x76" href="/img/logo3.png">
    <link rel="icon" type="image/png" href="{{ asset('material') }}/img/favicon.png">
    <title>{{ $title.' | Material Didáctico MaCa' ?? 'Material Didáctico Maca' }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="description" content="La mejor opción para personas que enseñan desde el corazón.">
    <meta name="keywords" content="materialdidacticomaca, material didactico maca, Material didáctico MaCa, MaCa, maca, Material didáctico, membresía VIP, lectoescritura, rezago, refuerzo, bitácora, cuaderno de trabajo, cuadernos de trabajo, lecto-esctirura, fichas de trabajo, matemáticas, preescolar, preescolar 1, preescolar 2, preescolar 3, primaria baja, apresto, silabas simples, silabas trabadas, vocales">
    <link rel="canonical" href="https://materialdidacticomaca.com/">


    <!-- Twitter Card data -->
    <meta name="twitter:title" content="Material Didáctico MaCa">
    <meta name="twitter:description" content="La mejor opción para personas que enseñan desde el corazón.">
    <meta name="twitter:image" href="/img/logo3.png" content="https://materialdidacticomaca.com/img/logo3.png">

    <!-- Open Graph data -->
    <meta property="og:title" content="Material Didáctico MaCa" />
    <meta property="og:url" content="https://materialdidacticomaca.com" />
    <meta property="og:image" href="/img/logo3.png" content="https://materialdidacticomaca.com/img/logo3.png" />
    <meta property="og:description" content="La mejor opción para personas que enseñan desde el corazón." />
    <meta property="og:site_name" content="Material Didáctico MaCa" />



    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!--     Fonts and icons new outline     -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />


    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet" />

    <!-- CSS Files -->

    <!-- <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> -->



    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" />
    <link href="{{ asset('material') }}/css/material-dashboard.css" rel="stylesheet" />

    <link href="{{ asset('css/text.min.css') }}" rel="stylesheet">


    <!-- @vite(['resources/css/app.scss', 'resources/js/app.js']) -->


    <!-- CSS slick -->
    <link rel="stylesheet" type="text/css" href="{{ asset('slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('slick/slick-theme.css') }}">

    <!-- CSS animate -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />





    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/add.css') }}" rel="stylesheet">









    @livewireStyles
</head>


<body class="{{ $class ?? '' }}  bg-dots-darker">
    @include('includes.spinner')
    @include('includes.modal.cart-modal')
    @include('includes.modal.product-show-modal')
    @include('includes.modal.login-modal')
    @include('includes.modal.info-asistencia')
    @include('includes.modal.video-asistencia')

    <a href="https://wa.me/message/GUNXZZ666PN3I1" class="floatWhats" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
    <style>
        #ofBar {
            display: none;
        }
    </style>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    @if (Route::is('dashboard','dashboard.*','products.*','memberships.*','category.*','package.*','degrees.*','users.*','comments.*','sales.*','ips.*','support.*','membership.sales', 'banners.*'))
    @include('layouts.page_templates.admin')

    @elseif(Route::is('profile.*','customer.*','order.*','grupos.*','add-student','group-report','group-report-excel'))
    @include('layouts.page_templates.user')

    @elseif(Route::is('login','register','password.email','password.request','password.reset'))
    @include('layouts.page_templates.guest')
    @else
    @include('layouts.page_templates.white')

    @endif








    <!--   Core JS Files   -->
    <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('material') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="{{ asset('material') }}/js/plugins/moment.min.js"></script>
    <!--  Plugin for Sweet Alert -->
    <!-- <script src="{{ asset('material') }}/js/plugins/sweetalert2.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Forms Validations Plugin -->
    <script src="{{ asset('material') }}/js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="{{ asset('material') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="{{ asset('material') }}/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="{{ asset('material') }}/js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="{{ asset('material') }}/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{ asset('material') }}/js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="{{ asset('material') }}/js/plugins/arrive.min.js"></script>






    <!--  Notifications Plugin    -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('material') }}/js/material-dashboard.js?v=2.1.0" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('material') }}/demo/demo.js"></script>
    <script src="{{ asset('material') }}/js/application.js"></script>
    <script src="{{ asset('material') }}/demo/jquery.sharrre.js"></script>



    <!-- iconos awesome new gmail solo maca-->
    <!-- <script src="https://kit.fontawesome.com/7a5f1c379e.js" crossorigin="anonymous"></script> -->

    <!-- iconos awesome anterior funcionando-->
    <script src="https://kit.fontawesome.com/58c5330fd0.js" crossorigin="anonymous"></script>



    <!-- search -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.4.1/snap.svg-min.js" type="text/javascript"></script>








    <!-- slick -->
    <script src="{{ asset('slick/slick.min.js') }}" type="text/javascript" charset="utf-8"></script>




    <!-- jquery-ui-search -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>

    <!-- select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>


    <!--  Data picker select range    -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- End Data picker select range    -->

    <!--  Ckeditor. -->
    <script src="{{ asset('assets/ckeditor-full/ckeditor.js') }}"></script>


    <!-- se agrega app con time -->
    <script src="{{ asset('js/main.js') }}?t=<?= time() ?>" type="text/javascript" defer> </script>

    @stack('js')

    @livewireScripts

</body>

</html>