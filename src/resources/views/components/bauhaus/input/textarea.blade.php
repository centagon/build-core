<div class="row {{ $errors->has($node->get('name')) ? 'error' : '' }}">
	<div class="small-12 medium-4">
		<label for="f-{{ $node->get('name') }}" class="text-right middle">
			{{ $node->get('label') }}
		</label>
	</div>
	<div class="small-12 medium-8">
		<textarea name="{{ $node->get('name') }}" {!! $node->getAttributes()  !!} {!! $node->getData()  !!} id="f-{{ $node->get('name') }}" placeholder="{{ $node->get('placeholder') }}">{{ old($node->get('name'), $node->get('value')) }}</textarea>

		@include('build.core::components.bauhaus.partials.field-error')
	</div>
</div>