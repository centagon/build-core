@section('body-class', 'clean variant-dark')
@include('build.core::components.layout.header')

    <div class="header-bar">
        <div class="header-bar__left"></div>
        <div class="header-bar__center"></div>
        <div class="header-bar__right"></div>
    </div>

    <section class="content">
        <div class="row">
            <div class="small-12">
                @yield('content')
            </div>
        </div>
    </section>

@include('build.core::components.layout.footer')