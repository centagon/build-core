@extends('build.core::layouts.clean')

@section('content')

    <div class="row">
        <div class="small-12">

            <ul class="list">
                @foreach ($groups as $group)
                    <label style="border: 1px solid #ccc; padding: 5px 10px;">
                        <span class="float-right">
                            <a href="{{ route('admin.groups.browser.delete', $group->getKey()) }}" onclick="return confirm('Are you sure?');">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>

                        <span class="tag" style="background: {{ $group->color }};"></span>
                        {{ $group->name }}
                    </label>
                @endforeach
            </ul>

            <form method="post" action="{{ route('admin.groups.browser.store') }}">
                <input type="hidden" name="type" value="{{ request()->get('type') }}">
                {{ csrf_field() }}

                <label for="f-name">New group</label>
                <input type="text" name="name" id="f-name">

                <label for="f-color">Group color</label>
                <input type="text" name="color" id="f-color" class="color-picker">

                <div>
                    <button class="button button--success">Create group</button>
                </div>
            </form>

        </div>
    </div>

@endsection