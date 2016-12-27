@extends('build.core::layouts.master')

@section('vue-content')

    <div class="row">
        <div class="small-12">

            <div class="page-header">
                <div class="page-header__item">
                    <h1>Assets</h1>
                </div>

                <div class="page-header__item">
                    <div class="button-actions">
                        <a href="{{ route('admin.assets.create') }}" class="button button--success">
                            New file
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('build.core::components.messages')

    <div class="row">
        <div class="small-12">
            <asset-container></asset-container>
        </div>
    </div>

@endsection