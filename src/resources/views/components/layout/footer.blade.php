
    @yield('sidebar')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.2.6/gridstack.min.css" />
    {!! Build\Core\Support\Facades\Asset::get('backend.js')->js() !!}
    <script type="text/javascript" src='//cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.2.6/gridstack.min.js'></script>
    @stack('javascripts')

    <script>
        $.fx.speeds._default = 100;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': config.csrf_token
            }
        });
    </script>

</body>
</html>