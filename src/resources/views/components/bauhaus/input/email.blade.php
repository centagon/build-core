<div class="row {{ $errors->has($node->get('name')) ? 'error' : '' }}" for="{{ $node->get('name') }}">
	<div class="small-12 medium-4">
		<label for="f-{{ $node->get('name') }}" class="text-right middle">
			{{ $node->get('label') }}
		</label>
	</div>
	<div class="small-12 medium-8">
		<input type="email" name="{{ $node->get('name') }}" {!! $node->getAttributes()  !!} {!! $node->getData()  !!} id="f-{{ $node->get('name') }}" value="{{ old($node->get('name'), $node->get('value')) }}" placeholder="{{ $node->get('placeholder') }}">

		@include('build.core::components.bauhaus.partials.field-error')
	</div>
</div>