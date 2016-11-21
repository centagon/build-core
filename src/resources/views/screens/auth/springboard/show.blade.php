@extends('build.core::layouts.clean')

@section('content')

    <div class="row">
        <div class="small-12 medium-4 medium-push-4">

            <section class="branding-bar">
                <section class="title">
                    <h3>{{ trans('build.core::auth.welcome', ['name' => auth()->user()->name]) }}</h3>
                    <p>{{ trans('build.core::auth.welcome-intro') }}</p>
                </section>
            </section>

            <ul class="list-group">
                @foreach ($websites as $website)
                    <li>
                        <a href="{{ route('admin.springboard.open', $website->getKey()) }}" class="list-group__item">
                            {{ $website->name }}
                        </a>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>

@endsection