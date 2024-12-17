<!DOCTYPE html>
<html lang="en-US" dir="ltr" data-navigation-type="default" data-navbar-horizontal-shape="default">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
@php
    $user = auth()->user();
    $profile = $user->profile;
@endphp

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
    @vite(['resources/js/app.js'])
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        @include('backend.partials.sidebar')
        @include('partials.header')
        @yield('main')
    </main>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    @include('partials.script')
</body>
</html>
