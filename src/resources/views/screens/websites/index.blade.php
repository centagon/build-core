@extends('build.core::layouts.master')

@section('content')

    <div class="row">
        <div class="small-12">

            <div class="page-header">
                <div class="page-header__item">
                    <h1>Websites</h1>
                </div>

                <div class="page-header__item">
                    <div class="button-actions">
                        <a href="{{ route('admin.websites.create') }}" class="button button--success">
                            New website
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('build.core::components.messages')

    <div class="row">

        @foreach ($websites as $website)
        <div class="small-12 medium-4">
            <div class="equalized panel panel--{{ $website->is_active ? 'success' : 'error' }}">

                @if ($website->is_active)
                    <div class="float-right">
                        <i class="fa fa-check"></i>
                    </div>
                @endif

                <h3 class="panel__title">
                    <a href="{{ route('admin.websites.edit', $website) }}" rel="tipsy" original-title="{{ $website->domain }}">{{ $website->name }}</a>
                </h3>

                <div class="panel__footer">
                    Last update: {{ $website->updated_at->diffForHumans() }}
                </div>
            </div>
        </div>
        @endforeach

    </div>

@endsection