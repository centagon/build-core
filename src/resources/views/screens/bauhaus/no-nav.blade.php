@include('build.core::components.layout.header')

    <div class="row">
        <div class="small-12">

            @foreach ($manager->getMapper()->getChildren() as $node)
                {!! $node->render() !!}
            @endforeach

        </div>
    </div>

@include('build.core::components.layout.footer')