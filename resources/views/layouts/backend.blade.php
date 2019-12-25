<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'Dashboard') :: {{ env('APP_NAME') }}</title>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    @stack('page_css')
</head>

<body id="page-top" class="sidebar-toggled">


    @include('backend.partials.navbar')

    <div id="wrapper">

        @include('backend.partials.sidebar-menu')

        <div id="content-wrapper">
            @include('backend.partials.breadcrumbs')
            @yield('content')
            <!-- Sticky Footer -->
            @include('backend.partials.footer')
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    @include('backend.partials.scroll-to-top')

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/js/app.js') }}"></script>

    @yield('page_scripts')
</body>

</html>
