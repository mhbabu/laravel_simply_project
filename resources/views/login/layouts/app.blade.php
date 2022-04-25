<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    {!! Html::style('assets/plugins/fontawesome-free/css/all.min.css') !!}
    {!! Html::style('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}
    {!! Html::style('assets/dist/css/adminlte.min.css') !!}
</head>
<body class="hold-transition login-page">
<div class="login-box">
@yield('header')
    @yield('content')
</div>
</body>
</html>
