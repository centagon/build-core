@include('build.core::components.layout.header')

    <div class="header-bar">
        <div class="header-bar__left"></div>
        <div class="header-bar__center"></div>
        <div class="header-bar__right"></div>
    </div>

    <header class="header">
        <div class="header__item">
            <ul class="header__nav">
                <li>
                    <a href="{{ build_route('dashboard') }}">
                        <img src="{{ asset('vendor/build/core/img/logo.svg') }}" style="width: 150px;">
                    </a>
                </li>

                @include('build.core::components.navigation', [
                    'items' => app('build.menu')->get('build.header-left')->roots()
                ])
            </ul>
        </div>

        <div class="header__item header__item--right">
            <ul class="header__nav">
                @include('build.core::components.navigation', [
                    'items' => app('build.menu')->get('build.header-right')->roots()
                ])
            </ul>
        </div>
    </header>

    <div id="vue-wrapper">
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

        <div class="sidebar">
            <div class="content"></div>
        </div>
    </div>

@include('build.core::components.layout.footer')