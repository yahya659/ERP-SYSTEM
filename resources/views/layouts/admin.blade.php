<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title')</title>
    {{-- ملفات الداش بورد الاادمن استدعينها عشان تاخذ الشكل --}}
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">

<link rel="stylesheet" href="{{asset('assets/admin/fonts/SansPro/SansPro.min.css') }}">
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap_rtl-v4.2.1/custom_rtl.css') }}">
<link rel="stylesheet" href="{{asset('assets/admin/css/mycustomstyle.css') }}">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.includes.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
               @include('admin.includes.saidebar')

        <!-- end Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->

        @include('admin.includes.content')
        <!-- /end.content-wrapper -->

        <!-- Control Sidebar -->

        <!-- /.control-sidebar -->

        <!--  Footer -->
        @include('admin.includes.footer')
        <!--  end Footer -->

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
<script src="{{asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
    @yield('script')
</body>

</html>
