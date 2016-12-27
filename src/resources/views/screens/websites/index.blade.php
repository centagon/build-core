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
        <div class="small-12">

            <table class="table table--selectable">
                <thead>
                    <tr>
                        <th width="20">
                            <input type="checkbox">
                        </th>
                        <th>Domain</th>
                        <th>Is activated?</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($websites as $website)
                        <tr class="selectable--row">
                            <td>
                                <input type="checkbox" value="{{ $website->getKey() }}">
                            </td>
                            <td>
                                <a href="{{ route('admin.websites.edit', $website) }}">
                                    {{ $website->name }}
                                </a>
                                <span class="sub-column">
                                    {{ $website->domain }}
                                </span>
                            </td>
                            <td>
                                @if ($website->is_active)
                                    <i class="fa fa-check"></i>
                                @endif
                            </td>
                            <td align="right">
                                <a href="{{ route('admin.websites.edit', $website) }}" class="button">Edit website</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="small-12 medium-6">
                    <button class="button button--error">test</button>
                </div>
                <div class="small-12 medium-6 text-right">
                    {{ $websites->links() }}
                </div>
            </div>

        </div>
    </div>

@endsection