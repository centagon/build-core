<a href="{{ $node->get('to', '#') }}" class="button button--{{ $node->get('style', 'secondary') }}" target="{{ $node->get('new-tab') == true ? '_blank' : '' }}" {{ $node->get('disabled') ? 'disabled' : '' }}>
    {!! $node->get('label') !!}
</a>