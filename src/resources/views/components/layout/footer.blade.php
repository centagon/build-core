    <script>
        var config = {
            base_url: '{{ url(config('build.core.uri')) }}'
        }
    </script>

    @yield('sidebar')

    <script src="{{ asset('vendor/build/core/js/vendor.js') }}"></script>
    <script src="{{ asset('vendor/build/core/js/core.js') }}"></script>
    {!! Build\Core\Support\Facades\Asset::scripts() !!}
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