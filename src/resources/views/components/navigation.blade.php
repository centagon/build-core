@foreach ($items as $item)

    @if ($item->hasChildren())
        <li>
            <a href="{!! $item->url() !!}" class="dropdown-toggle">
                {!! $item->title !!}
            </a>

            <ul class="dropdown-menu">
                @include('build.core::components.navigation', ['items' => $item->children()])
            </ul>
        </li>
    @else
        <li>
            <a href="{{ $item->url() }}">
                {{ $item->title }}
            </a>
        </li>
    @endif

@endforeach