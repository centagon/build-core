@extends('build.core::layouts.clean')

@section('content')

    <div class="row">
        <div class="small-12 medium-4 medium-push-4">

            <form method="post" action="{{ route('admin.sessions.store') }}">
                {{ csrf_field() }}

                <div id="header-logo">
                    <img src="{{ asset('vendor/build/core/img/logo-horizontal.png') }}" width="181" height="99">
                </div>

                <div class="panel">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="callout">
                        <input type="email" id="f-email" name="email" placeholder="{{ trans('build.core::auth.email-address') }}" required>
                        <input type="password" id="f-password" name="password" placeholder="{{ trans('build.core::auth.password') }}" required>

                        <div class="float-right">
                            <button class="button button--success">
                                <i class="fa fa-lock"></i>
                                {{ trans('build.core::auth.sign-in') }}
                            </button>
                        </div>

                        <label>
                            <input type="hidden" name="remember_me" value="0">
                            <input type="checkbox" name="remember_me" value="1" checked>
                            {{ trans('build.core::auth.remember-me') }}
                        </label>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection