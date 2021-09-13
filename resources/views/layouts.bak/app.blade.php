<!--
=========================================================
 Light Bootstrap Dashboard - v2.0.1
=========================================================

 Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.  -->
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" /> --}}
    <!-- CSS Files -->
    <link href="{{ asset('theme/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('theme/assets/css/light-bootstrap-dashboard.css') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('theme/assets/css/demo.css') }}" rel="stylesheet" />

    <link href="{{ asset('theme.bak/assets/css/pe-icon-7-stroke.css') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" /> --}}
    <link href="{{ asset('fontawesome-free-5.12.0-web/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />

    @yield('styles')
    @stack('styles')
    <script>
        let token = '{{ csrf_token() }}'
    </script>
    @yield('scripts_top')
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main-panel">
            <!-- Navbar -->
            @include('layouts.navbar')
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    @include('layouts.bottom-nav')
                    <p class="copyright pull-right">
                        &copy; {{ date('Y') }} <a href="{{ url('/') }}">{{ config('app.name') }}</a>
                    </p>
                </div>
            </footer>
        </div>
    </div>

    @stack('html_bottom')

<!--   Core JS Files   -->
<script src="{{ asset('theme/assets/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/assets/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('theme/assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{ asset('theme/assets/js/plugins/bootstrap-switch.js') }}"></script>
<!--  Google Maps Plugin    -->
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
<!--  Chartist Plugin  -->
<script src="{{ asset('theme/assets/js/plugins/chartist.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('theme/assets/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="{{ asset('theme/assets/js/light-bootstrap-dashboard.js?v=2.0.0') }}" type="text/javascript"></script>
<!-- DataTable -->
<script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ asset('theme/assets/js/demo.js') }}"></script>
<script src="{{ asset('js/helpers.js') }}"></script>
@yield('scripts_bottom')
@stack('scripts_bottom')
<script type="text/javascript">
    $(document).ready(function(){

        @if(Session::has('global-info'))
            {!!
            "$.notify({
                icon: 'pe-7s-info',
                message: '".Session::get('global-info')."'

            },{
                type: 'info',
                timer: 5000
            });"
            !!}
        @endif

        @if(Session::has('global-success'))
            {!!
            "$.notify({
                icon: 'pe-7s-check',
                message: '".Session::get('global-success')."'

            },{
                type: 'success',
                timer: 5000
            });"
            !!}
        @endif

        @if(Session::has('global-warning'))
            {!!
            "$.notify({
                icon: 'pe-7s-attention',
                message: '".Session::get('global-warning')."'

            },{
                type: 'warning',
                timer: 5000
            });"
            !!}
        @endif

        @if(Session::has('global-danger'))
            {!!
            "$.notify({
                icon: 'pe-7s-attention',
                message: '".Session::get('global-danger')."'

            },{
                type: 'danger',
                timer: 5000
            });"
            !!}
        @endif
    })

</script>
</body>
</html>
