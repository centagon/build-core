@extends('build.core::layouts.master')

@section('content')

    <div class="page-header">
        <h1>
            {{ \Build\Core\Support\Facades\Discovery::backendWebsite()->name }}
            &mdash; Dashboard
        </h1>
    </div>

@endsection