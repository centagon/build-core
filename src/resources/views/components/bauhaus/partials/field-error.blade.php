{{-- @if ($errors->has($node->get('name'))) --}}
	<span class="form-error" for="{{ $node->get('name') }}">
		{{ $errors->first($node->get('name')) }}
	</span>
{{-- @endif --}}