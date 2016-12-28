<tr class="selectable--row">
    @if ($node->selectable() === true)
        <td width="20">
            <input type="checkbox" class="row-id" value="{{ $row->getKey() }}">
        </td>
    @endif

    @foreach ($row as $item)
        <td align="{{ $item->get('align', 'left') }}">
            {!! $item->render() !!}
        </td>
    @endforeach
</tr>