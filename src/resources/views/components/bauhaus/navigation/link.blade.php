<a href="{{ $node->get('to') }}">
    {!! $node->get('value') !!}
</a>

@if ($node->has('subcolumn'))
    <span class="sub-column">
        {{ $node->get('subcolumn') }}
    </span>
@endif