@extends('build.core::layouts.clean')

@section('content')

    <div class="row">
        <div class="small-12 medium-4 medium-push-4">

            <div id="header-logo">
                <img src="{{ asset('vendor/build/core/img/logo-horizontal.png') }}">
            </div>

            <ul class="list-group">
                @foreach ($websites as $website)
                    <li>
                        <a href="{{ route('admin.springboard.open', $website->getKey()) }}" class="list-group__item" style="border-left: 10px solid {{ $website->color }};">
                            {{ $website->name }}
                        </a>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>

@endsection