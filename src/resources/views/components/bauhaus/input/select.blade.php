<div class="row {{ $errors->has($node->get('name')) ? 'error' : '' }}">
	<div class="small-12 medium-4 columns">
		<label for="f-{{ $node->get('name') }}" class="text-right middle">
			{{ $node->get('label') }}
		</label>
	</div>
	<div class="small-12 medium-8 columns">

		@if ( $node->isMultiple() )
			<select name="{{ $node->get('name') }}[]" id="f-{{ $node->get('name') }}" {!! $node->getData()  !!} {!! $node->getAttributes()  !!} multiple>
				@else
					<select name="{{ $node->get('name') }}" id="f-{{ $node->get('name') }}" {!! $node->getData()  !!} {!! $node->getAttributes()  !!} >
						<option value="">Select an option</option>
						@endif

						@if( $node->isMultiple() )
							@foreach ($node->getOptions() as $key => $value)
								@if ( array_get( $node->getOld(), $key ) )
									<option value="{{ $key }}" selected>{{ $value }}</option>
								@else
									<option value="{{ $key }}">{{ $value }}</option>
								@endif
							@endforeach
						@else
							@foreach ($node->getOptions() as $key => $value)
								@if ( $node->getOld() == $key )
									<option value="{{ $key }}" selected>{{ $value }}</option>
								@else
									<option value="{{ $key }}">{{ $value }}</option>
								@endif
							@endforeach
						@endif

					</select>

			@include('build.core::components.bauhaus.partials.field-error')
	</div>
</div>