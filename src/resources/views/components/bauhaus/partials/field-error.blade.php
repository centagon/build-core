@if ($errors->has($node->get('name')))
	<span class="form-error">
		{{ $errors->first($node->get('name')) }}
	</span>
@endif