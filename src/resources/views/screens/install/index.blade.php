@extends('build.core::layouts.clean')

@section('content')

	<h1>Installation</h1>

	@foreach (alert()->messages() as $key => $messages)
		@foreach ($messages as $message)
			<div class="{{ $key }} panel">
				{{ $message }}
			</div>
		@endforeach
	@endforeach

	<form method="post" action="{{ route('install.run') }}">
		{{ method_field('PUT') }}
		{{ csrf_field() }}

		<textarea name="env" style="width: 100%; height: 300px;">{{ $env }}</textarea>

		<button>Update .env file and run the installer</button>
	</form>

@endsection