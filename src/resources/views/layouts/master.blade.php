@include('build.core::components.layout.header')

    <header>
        <nav>
            <ul class="nav-left dropdown">
                <li>
                    <a href="{{ build_route('dashboard') }}">
                        <img src="{{ asset('vendor/build/core/img/logo.svg') }}" style="width: 150px;">
                    </a>
                </li>

                @include('build.core::components.navigation', [
                    'items' => app('build.menu')->get('build.header-left')->roots()
                ])
            </ul>

            <ul class="nav-right dropdown">
                @include('build.core::components.navigation', [
                    'items' => app('build.menu')->get('build.header-right')->roots()
                ])
            </ul>
        </nav>
    </header>

    <section class="sub-header">
        @yield('sub-header')
    </section>

    <section class="content">
        <div class="row">
            <div class="small-12">
                @yield('content')
            </div>
        </div>
    </section>

@include('build.core::components.layout.footer')