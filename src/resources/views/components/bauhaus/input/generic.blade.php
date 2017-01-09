<div class="row {{ $errors->has($node->name) ? 'error' : '' }}" for="{{ $node->get('name') }}">
	<div class="small-12 medium-6 medium-push-3">
		<label for="f-{{ $node->name }}">
			{{ $node->label }}
		</label>
	</div>
	<div class="small-12 medium-6 medium-push-3">
		<div class="{{ $node->has('addon') ? 'input-group' : '' }}">
			
			@if ($node->has('addon'))
				<span class="input-group__addon">
					{{ $node->addon }}
				</span>
			@endif

			<input id="f-{{ $node->name }}" {{ $node->renderedAttributes() }}>
		</div>

		@include('build.core::components.bauhaus.partials.field-error')
	</div>
</div>