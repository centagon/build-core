<div class="row {{ $errors->has($node->get('name')) ? 'error' : '' }}">
	<div class="small-12 medium-6 medium-push-3">
		<label for="{{ $node->get('name') }}">
			{{ $node->get('label') }}
		</label>
	</div>
	<div class="small-12 medium-6 medium-push-3">
		<textarea {{ $node->renderedAttributes() }}>{{ old($node->name, $node->value) }}</textarea>

		@include('build.core::components.bauhaus.partials.field-error')
	</div>
</div>