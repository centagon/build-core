@if ($node->rows->isEmpty() && $node->get('empty') !== false)
    @include('build.core::components.bauhaus.data.no-records')
@else

    <table class="table {{ $node->selectable() === true ? 'selectable' : '' }}">

        @if ($node->get('head') !== false)
            <thead>
                @include('build.core::components.bauhaus.data.table.head')
            </thead>
        @endif

        <tbody>
            @foreach ($node->rows as $row)
                @include('build.core::components.bauhaus.data.table.body')
            @endforeach
        </tbody>

    </table>

@endif