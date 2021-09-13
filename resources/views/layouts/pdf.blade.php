<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <style type="text/css">
        @import url('http://fonts.googleapis.com/css?family=Poiret+One&display=swap');
        @import url('http://fonts.googleapis.com/css?family=Poppins:300,600&display=swap');
        @import url('{!! asset('css/pdf.min.css') !!}');
    </style>
    @stack('styles')
</head>
<body>
    <div class="title">
        <h4>
            @yield('title')
        </h4>
    </div>
    <div class="wrapper">
        <div class="container">
            @yield('content')
        </div>
    </div>
</body>
</html>
