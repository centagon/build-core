@extends('build.core::layouts.clean')

@section('content')

    <div class="row">
        <div class="small-12 medium-4 medium-push-4">

            <form method="post" action="{{ route('admin.sessions.store') }}">
                {{ csrf_field() }}

                <div class="panel">
                    <section class="branding-bar">
                        <section class="title text-center">
                            <h3>Centagon Build</h3>
                        </section>
                    </section>

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
                        <input type="email" id="f-email" name="email" placeholder="Email address" required>
                        <input type="password" id="f-password" name="password" placeholder="Password" required>

                        <label>
                            <input type="hidden" name="remember_me" value="0">
                            <input type="checkbox" name="remember_me" value="1" checked>
                            Remember me
                        </label>

                        <br>

                        <button class="button button--success">
                            <i class="fa fa-lock"></i>
                            Sign-in
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection