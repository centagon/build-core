<div class="row {{ $errors->has($node->get('name')) ? 'error' : '' }}">
	<div class="small-12 medium-4">
		<label for="f-{{ $node->get('name') }}" class="text-right middle">
			{{ $node->get('label') }}
		</label>
	</div>
	<div class="small-12 medium-8">
		<input type="text" disabled value="{{ $node->get('value') }}">
	</div>
</div>