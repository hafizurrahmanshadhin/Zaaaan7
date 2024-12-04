<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    @include('partials.faviocns')

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    @include('partials.style')
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        @yield('main')
    </main>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    @include('partials.script')
</body>


<!-- Mirrored from prium.github.io/phoenix/v1.18.1/pages/authentication/simple/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Aug 2024 06:14:12 GMT -->

</html>
