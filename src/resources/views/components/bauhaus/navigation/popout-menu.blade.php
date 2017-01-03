<div class="popout__hover {{ $node->align ? 'popout__hover--'.$node->align : '' }}">
    <a class="popout__hover__button">
        <i class="fa fa-chevron-down"></i>
        @if ($node->label)
        <span class="popout__hover__button__label">{{ $node->label }}</span>
        @endif
    </a>
    <ul class="popout__hover__menu">
        @foreach ($node->getChildren() as $child)
        <li>
            {!! $child->setRow($node->getRow())->render() !!}
        </li>
        @endforeach
    </ul>
</div>