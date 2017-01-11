
    @yield('sidebar')

    {!! Build\Core\Support\Facades\Asset::get('backend.js')->js() !!}
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