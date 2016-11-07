<div class="row {{ $errors->has($node->get('name')) ? 'error' : '' }}">
	<div class="small-12 medium-4">
		<label for="f-{{ $node->get('name') }}" class="text-right middle">
			{{ $node->get('label') }}
		</label>
	</div>
	<div class="small-12 medium-8">
		<input type="text" name="{{ $node->get('name') }}" {!! $node->getAttributes()  !!} {!! $node->getData()  !!} id="f-{{ $node->get('name') }}" value="{{ old($node->get('name'), $node->get('value')) }}" placeholder="{{ $node->get('placeholder') }}">

		@if ($errors->has($node->get('name')))
			<span class="form-error is-visible">
                {{ $errors->first($node->get('name')) }}
            </span>
		@endif
	</div>
</div>