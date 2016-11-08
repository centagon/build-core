<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compitable" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="_token" content="{{ csrf_token() }}">
    @stack('meta-extra')

    <title>[{{ strtoupper(app()->environment()) }}] &mdash; Centagon Build</title>

    <link rel="stylesheet" href="{{ asset('vendor/build/core/css/core.css') }}">
    {!! Build\Core\Support\Facades\Asset::styles() !!}
    @stack('stylesheets')

</head>
<body class="@yield('body-class')">