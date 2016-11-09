<div class="row {{ $errors->has($node->get('name')) ? 'error' : '' }}">
	<div class="small-12 medium-4">
		<label for="{{ $node->get('name') }}" class="text-right middle">
			{{ $node->get('label') }}
		</label>
	</div>
	<div class="small-12 medium-8">
		<textarea {{ $node->renderedAttributes() }}>{{ old($node->name, $node->value) }}</textarea>

		@include('build.core::components.bauhaus.partials.field-error')
	</div>
</div>