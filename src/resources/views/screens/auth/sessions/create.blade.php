@extends('build.core::layouts.clean')

@section('content')

    <div class="row">
        <div class="small-12 medium-5">

            <form method="post" action="{{ route('admin.sessions.store') }}">
                {{ csrf_field() }}

                <section class="branding-bar">
                    <section class="title text-center">
                        <h3>{{ config('build.core.title') }}</h3>
                    </section>
                </section>

                <div class="callout">
                    <input type="email" id="f-email" name="email" placeholder="Email address" required>
                    <input type="password" id="f-password" name="password" placeholder="Password" required>

                    <label>
                        <input type="hidden" name="remember_me" value="0">
                        <input type="checkbox" name="remember_me" value="1" checked>
                        Remember me
                    </label>

                    <br>

                    <button class="expanded success button">
                        <span class="material-icons">lock</span>
                        Sign-in
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection