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

    <div class="row">
        <div class="small-12 medium-6">
            @if ($node->selectable() === true && $node->has('actions'))
                @foreach ($node->get('actions') as $action)
                    {!! $action->render() !!}
                @endforeach
            @endif
        </div>

        <div class="small-12 medium-6 text-right">
            @if (app('build.bauhaus.query') instanceof Illuminate\Pagination\LengthAwarePaginator)
                {{ app('build.bauhaus.query')->appends(request()->all())->links() }}
            @endif
        </div>
    </div>

@endif