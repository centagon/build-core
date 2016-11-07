<form method="post" action="{{ $node->get('action', '#') }}" {!! $node->get('files') == true ? 'enctype="multipart/form-data"' : ''  !!}>
	{{ csrf_field() }}
	{{ method_field($node->get('method', 'POST')) }}

	@foreach ($node->getChildren() as $child)
		{!! $child->render() !!}
	@endforeach
</form>