@section('sub-header')

    <div class="row">
        <div class="small-12">

            <section class="title">
                @if ($node->hasChildren())
                    <div class="float-right">
                        @foreach ($node->getChildren() as $child)
                            {!! $child->render() !!}
                        @endforeach
                    </div>
                @endif

                <h1>
                    {{ $node->title }}

                    @if ($node->has('subtitle'))
                        <span>&mdash; {{ $node->subtitle }}</span>
                    @endif

                    @if ($node->has('scopes'))
                        <div class="title__scopes">
                            <a href="#">
                                <span class="material-icons">filter_list</span>
                            </a>
                        </div>
                    @endif
                </h1>

                @if ($node->has('scopes'))
                    @include('build.core::components.bauhaus.scopes')
                @endif
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