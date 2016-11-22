<div class="row">
    <div class="small-12">

        <div class="page-header">
            <div class="page-header__item">
                <h1>{{ $node->title }}</h1>
            </div>

            <div class="page-header__item">
                @if ($node->hasChildren())
                    <div class="button-actions">
                        @foreach ($node->getChildren() as $child)
                            {!! $child->render() !!}
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

@foreach (alert()->messages() as $key => $messages)
    @foreach ($messages as $message)
        <div class="panel panel--{{ $key }}">
            {{ $message }}
        </div>
    @endforeach
@endforeach

{{--
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
                    <div class="panel panel--{{ $key }}">
                        {{ $message }}
                    </div>
                @endforeach
            @endforeach

        </div>
    </div>

@endsection
--}}