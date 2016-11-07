@extends('build.core::layouts.clean')

@section('content')

    <div class="row">
        <div class="small-12 medium-5 medium-centered columns">

                <div class="callout">

                    <ul>
                        @foreach ($websites as $website)
                            <li>
                                <a href="{{ route('admin.springboard.open', $website->getKey()) }}">
                                    {{ $website->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

        </div>
    </div>

@endsection