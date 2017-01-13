@extends('build.core::layouts.master')

@section('vue-content')
    <div class="row">
        <div class="small-12">

            @foreach ($manager->getMapper()->getChildren() as $node)
                {!! $node->render() !!}
            @endforeach

        </div>
    </div>
@endsection