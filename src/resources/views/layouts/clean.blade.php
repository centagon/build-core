@section('body-class', 'clean')
@include('build.core::components.layout.header')

    <section class="content">
        <div class="row">
            <div class="small-12">
                @yield('content')
            </div>
        </div>
    </section>

@include('build.core::components.layout.footer')