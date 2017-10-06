<section class="form-actions">
	<div class="row">
		<div class="small-12 medium-6 medium-push-3">
			<button class="button button--success">
				{{ $node->get('success-label', 'Save changes') }}
			</button>
			<a class="button button--secondary" href="{{ $node->get('cancel-url') ? : app('url')->previous() }}">
				{{ $node->get('cancel-label', 'Cancel') }}
			</a>

			@if ($url = $node->get('remove-url'))
				<div class="float-right">
					<a class="button button--error" id="delete-button" href="{{ $url }}" data-open-sidebar="delete-resource-sidebar">
						Delete
					</a>
				</div>
			@endif
		</div>
	</div>
</section>

@section('sidebar')
	@if ($url = $node->get('destroy-url'))
		<div class="sidebar" id="delete-resource-sidebar" data-sidebar>
			<form method="post" action="{{ $url }}">
				{{ csrf_field() }}

				<div class="content"></div>
			</form>
		</div>
	@endif
@endsection
