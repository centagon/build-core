@include('build.core::components.layout.header')

    <div class="header-bar">
        <div class="header-bar__left"></div>
        <div class="header-bar__center"></div>
        <div class="header-bar__right"></div>
    </div>

    <header class="header">
        <div class="header__item">
            <ul class="header__nav">
                <li id="logo">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('vendor/build/core/img/logo.svg') }}">
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

    <section class="sub-header">
        @yield('sub-header')
    </section>

    <section class="content" id="vue-wrapper">
        @if ($__env->yieldContent('fluid-content'))
            @yield('fluid-content')
        @endif

        <div class="row">
            <div class="small-12">
                @yield('content')
            </div>
        </div>
        
        @yield('vue-content')
    </section>

    <div class="sidebar">
        <div class="content"></div>
    </div>

    <div class="sidebar-overflow"></div>

@include('build.core::components.layout.footer')