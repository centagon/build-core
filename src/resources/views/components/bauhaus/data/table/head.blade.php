<tr>

	@if ($node->selectable() === true)
		<th width="20">
			<input type="checkbox">
		</th>
	@endif

	@foreach ($node->getChildren() as $child)
		<th align="{{ $child->get('align', 'left') }}">
			@if ($child->get('hidden') !== true)
				{!! $child->get('label') !!}
			@endif
		</th>
	@endforeach

</tr>