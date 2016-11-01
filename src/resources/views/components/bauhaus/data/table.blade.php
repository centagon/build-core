@if ($node->rows->isEmpty() && $node->get('empty') !== false)
    @include('build.core::components.bauhaus.data.no-records')
@else

    <table class="{{ $node->selectable() ? 'selectable' : '' }}">

        @if ($node->get('head'))
            test
        @endif

        <tbody>
            @foreach ($node->rows as $row)
                @include('build.core::components.bauhaus.data.table.body')
            @endforeach
        </tbody>

    </table>

@endif