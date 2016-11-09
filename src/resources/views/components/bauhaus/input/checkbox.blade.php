<div class="row{{ $errors->has($node->name) ? ' error' : '' }}">
	<div class="small-12 medium-8 medium-push-4">
		<label>
			<input type="hidden" name="{{ $node->get('name') }}" value="0">
			<input {{ $node->renderedAttributes() }}>

			{{ $node->label }}
		</label>

		@include('build.core::components.bauhaus.partials.field-error')
	</div>
</div>