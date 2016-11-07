<div class="row {{ $errors->has($node->get('name')) ? 'error' : '' }}">
	<div class="small-12 medium-8 medium-push-4 columns">
		<label>
			<input type="hidden" name="{{ $node->get('name') }}" value="0">
			<input type="checkbox" name="{{ $node->get('name') }}" id="f-{{ $node->get('name') }}" value="1" {{ old($node->get('name'), $node->get('value')) == 1 ? 'checked' : '' }} {!! $node->getAttributes() !!}>
			{{ $node->get('label') }}
		</label>

		@if ($errors->has($node->get('name')))
			<span class="form-error is-visible">
                {{ $errors->first($node->get('name')) }}
            </span>
		@endif
	</div>
</div>