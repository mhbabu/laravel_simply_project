<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <title>{{ env('APP_NAME','Application') }} | @yield('title','Administration')</title>

    <!-- Font Awesome Icons -->
    <link rel="icon" type="image/x-icon" href="{{ url('/assets/img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    {!! Html::style('/assets/plugins/fontawesome-free/css/all.min.css') !!}
    {!! Html::style('/assets/plugins/toaster/css/toaster.min.css') !!}
    {!! Html::style('/assets/dist/css/adminlte.min.css') !!}
    {!! Html::style('/assets/dist/css/custom.css') !!}
    {!! Html::style('/assets/plugins/sweet-alert/css/sweetalert.min.css') !!}
    @yield('header-css')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <!-- Navbar -->
    @include('includes.header')

    <!-- Main Sidebar Container -->
    @include('includes.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">

        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @include('includes.messages')
                @yield('content')
            </div>
            <!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    @include('includes.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
{!! Html::script('/assets/plugins/jquery/jquery.min.js') !!}
{!! Html::script('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}
{!! Html::script('/assets/plugins/toaster/js/toaster.min.js') !!}
{!! Html::script('/assets/dist/js/adminlte.js') !!}
{!! Html::script('/assets/plugins/sweet-alert/js/sweetalert.min.js') !!}
{!! Html::script('/assets/plugins/jquery/jquery.validate.min.js') !!}
{!! Html::script('/assets/dist/js/custom.js') !!}
{!! Html::script('/assets/dist/js/common.js') !!}

@if(session()->has('success'))
    {!! Toastr::success(session('success'), 'Success'); !!}
@endif

@if(session()->has('warning'))
    {!! Toastr::warning(session('warning'), 'Warning'); !!}
@endif

@if(session()->has('error'))
    {!! Toastr::error(session('error'), 'Error'); !!}
@endif

@if(session()->has('info'))
    {!! Toastr::info(session('info'), 'Info'); !!}
@endif

{!! Toastr::message() !!}

@yield('footer-script')
</body>

</html>
