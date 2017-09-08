@extends('build.core::layouts.master')

@section('content')

    <div class="row">
        <div class="small-12">

            <div class="page-header">
                <div class="page-header__item">
                    <h1>Warning: Resource belongs to another website</h2>
                </div>

                <div class="page-header__item">
                    <div class="button-actions">
                        <a href="{{ route('admin.dashboard') }}" class="button">
                            Return to dashboard
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('build.core::components.messages')

    <div class="row">

        <div class="small-12">
            <p>
                The resource you are trying to access does not belong to the website that you are logged in to.
            </p>
            @if (isset($website))
            <p>
                Please switch to <strong>{{ $website->name }}</strong> to access this resource.
            </p>
            @endif
        </div>

    </div>

@endsection