<div class="row {{ $errors->has($node->name) ? 'error' : '' }}" for="{{ $node->get('name') }}">
	<div class="small-12 medium-6 medium-push-3">
		<label for="f-{{ $node->name }}">
			{{ $node->label }}
		</label>
	</div>
	<div class="small-12 medium-6 medium-push-3">
        <input-asset id="f-{{ $node->name }}" {{ $node->renderedAttributes() }}>
            <input type="hidden" {{ $node->renderedAttributes() }} />
        </input-asset>

		@include('build.core::components.bauhaus.partials.field-error')
	</div>
</div>