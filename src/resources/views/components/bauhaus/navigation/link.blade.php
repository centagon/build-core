<a 
    href="{{ $node->getUrl() }}"
    @if ($sidebar = $node->get('sidebar'))
    data-open-sidebar = {{ $sidebar }}
    @endif
    >
    
    @if ($icon = $node->get('icon'))
    <i class="fa fa-{{ $icon }}"></i>
    @endif
    
    {!! $node->get('value') !!}
</a>

@if ($node->has('subcolumn'))
    <span class="sub-column">
        {{ $node->get('subcolumn') }}
    </span>
@endif

@push('javascripts')
    @if ($sidebar = $node->get('sidebar'))
        <div id="{{ $sidebar }}" class="sidebar">
            <div class="content"></div>
        </div>
    @endif
@endpush