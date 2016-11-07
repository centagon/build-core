@extends('build.core::layouts.master')

@section('sub-header')

	<div class="row">
		<div class="small-12">

			<section class="title">
				<div class="float-right">
					<a href="{{ route('admin.colors.create') }}" class="button button--success">
						New color
					</a>
				</div>

				<h1>Colors</h1>
			</section>

			@foreach (alert()->messages() as $key => $messages)
				@foreach ($messages as $message)
					<div class="{{ $key }} callout">
						{{ $message }}
					</div>
				@endforeach
			@endforeach

		</div>
	</div>

@endsection

@section('content')

	<div class="row">
		@foreach ($colors as $color)

			<div class="small-6 medium-4 large-3">
				<div class="panel" style="background-color: {{ $color->hex_color }};">
					<a href="{{ route('admin.colors.edit', $color) }}" style="color: {{ $color->best_contrast }};">
						{{ $color->name }}
					</a>
				</div>
			</div>

		@endforeach
	</div>

@endsection