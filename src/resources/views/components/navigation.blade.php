@foreach ($items as $item)

    {{-- Whenever no permissions are set or the users permissions are met. --}}
    @if ($item->data('permission') == null || Gate::allows($item->data('permission')))

        @if ($item->hasChildren())
            <li class="header__dropdown">
                <a href="{!! $item->url() !!}" class="header__dropdown__toggle">
                    {!! $item->title !!}
                    <span class="caret"></span>
                </a>

                <ul class="header__dropdown__menu">
                    @include('build.core::components.navigation', ['items' => $item->children()])
                </ul>
            </li>
        @else
            <li>
                <a href="{{ $item->url() }}">
                    {!! $item->title !!}
                </a>
            </li>
        @endif

        @if ($item->divider)
            <li class="divider"></li>
        @endif

    @endif

@endforeach