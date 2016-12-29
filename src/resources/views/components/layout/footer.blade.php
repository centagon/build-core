
    @yield('sidebar')

    {!! Build\Core\Support\Facades\Asset::get('backend.js')->js() !!}
    @stack('javascripts')

    <script>
        $.fx.speeds._default = 100;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
    </script>

</body>
</html>