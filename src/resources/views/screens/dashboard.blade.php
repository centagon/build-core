@section('body-class', 'clean variant-dark')
@extends('build.core::layouts.master')

@section('content')

    @if (! $blocks->isEmpty())
    <div class="row">
        <div class="small-12">
            <div class="page-header">
                <div class="page-header__item">
                    <h1>
                        {{ \Build\Core\Support\Facades\Discovery::backendWebsite()->name }}
                        &mdash; Dashboard
                    </h1>
                </div>
                <div class="page-header__item">
                    <a href="{{ route('admin.dashboard.create') }}" data-open-sidebar="dashboard-sidebar" class="button button--success button--icon-left">
                        <i class="fa fa-plus"></i>
                        Add new block
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($blocks->isEmpty())
        <div class="panel text-center" style="margin-top: 50px;">
            <p>There are no blocks added to the <strong>{{ \Build\Core\Support\Facades\Discovery::backendWebsite()->name }}</strong> dashboard.</p>
            <a href="{{ route('admin.dashboard.create') }}" data-open-sidebar="dashboard-sidebar" class="button button--success button--icon-left">
                <i class="fa fa-plus"></i>
                Add your first block
            </a>
        </div>
    @endif

    <div>
        <div class="grid-stack">

            @foreach ($blocks as $block)
                <div class="grid-stack-item" {!! $block->render_attributes() !!}>
                    <div class="grid-stack-item-content">
                        <div class="grid-stack-item-header" style="background-color: {{ $block->color }};">
                            <div class="float-right">
                                <a href="{{ route('admin.dashboard.edit', $block->getKey()) }}" data-open-sidebar="dashboard-sidebar" class="button--small button--selected button">
                                    Edit
                                </a>
                                <a href="{{ route('admin.dashboard.remove', $block->getKey()) }}" class="button--small button--error button" onclick="return confirm('Are you sure?');">
                                    Remove
                                </a>
                            </div>
                            <h3>{{ $block->title }}</h3>
                        </div>
                        <div class="grid-stack-item-inside">
                            @if ($image = $block->image)
                                <div class="row">
                                    <div class="small-12 medium-4">
                                        <img src="{{ $image }}" width="100%">
                                    </div>
                                    <div class="small-12 medium-8">
                                        {!! $block->content !!}

                                        @if ($label = $block->button_label)
                                            <p>
                                                <a href="{{ $block->button_url ?: '#' }}" class="button">{{ $label }}</a>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                {!! $block->content !!}
                                @if ($label = $block->button_label)
                                    <a href="{{ $block->button_url ?: '#' }}" class="button">{{ $label }}</a>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div id="dashboard-sidebar" class="sidebar">
        <div class="content"></div>
    </div>

@endsection

@push('javascripts')
<script>
    $('.grid-stack').gridstack({
        animate: true,
    });
</script>
@endpush