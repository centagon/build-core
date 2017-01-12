<section class="form-actions">
	<div class="row">
		<div class="small-12 medium-6 medium-push-3">
			<button class="button button--success">
				{{ $node->get('success-label', 'Save changes') }}
			</button>
			<a class="button button--secondary" href="{{ $node->get('cancel-url') ? : app('url')->previous() }}">
				{{ $node->get('cancel-label', 'Cancel') }}
			</a>
		</div>
	</div>
</section>