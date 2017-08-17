<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compitable" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    @stack('meta-extra')

    <title>[{{ strtoupper(app()->environment()) }}] &mdash; Centagon Build</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    {!! Build\Core\Support\Facades\Asset::get('backend.css')->css() !!}
    @stack('stylesheets')

    <script>
        var config = {
            debug: '{{ config('app.debug') }}',
            root_url: '{{ url('/') }}',
            base_url: '{{ url(config('build.core.uri')) }}',
            csrf_token: '{{ csrf_token() }}'
        };
    </script>

</head>
<body class="@yield('body-class')">
