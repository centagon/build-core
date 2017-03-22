<div class="row{{ $errors->has($node->name) ? ' error' : '' }}" for="{{ $node->get('name') }}">
	<div class="small-12 medium-6 medium-push-3">
		<label>
			<input type="hidden" name="{{ $node->get('name') }}" value="0">
			<input {{ $node->renderedAttributes() }}>

			{{ $node->label }}
		</label>

		@include('build.core::components.bauhaus.partials.field-error')
	</div>
</div>