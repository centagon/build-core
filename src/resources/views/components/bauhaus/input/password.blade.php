<div class="row {{ $errors->has($node->get('name')) ? 'error' : '' }}" for="{{ $node->get('name') }}">
	<div class="small-12 medium-6 medium-push-3">
		<label for="f-{{ $node->get('name') }}" class="text-right middle">
			{{ $node->get('label') }}
		</label>
	</div>
	<div class="small-12 medium-6 medium-push-3">
		<input {{ $node->renderedAttributes() }}>

		@include('build.core::components.bauhaus.partials.field-error')
	</div>
</div>