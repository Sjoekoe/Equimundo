@extends('layout.outer-app')

@section('content')
    <div id="container" class="cls-container">
        <div id="bg-overlay" class="bg-img" style="background-image: url({{ asset('images/horses.jpg') }})"></div>

        @include('layout.partials._outer_app_header')

        <div class="cls-content">
            <div class="cls-content-sm panel">
                <div class="panel-body">
                    @if (session()->has('status'))
                        <p>{{ session()->get('status') }}</p>
                    @endif
                    <p class="pad-btm">Reset your password.</p>
                    {{ Form::open(['class' => 'form-horizontal']) }}
                        {{ Form::hidden('token', $token) }}
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email">
                        </div>
                        @include('layout.partials._error_message', ['field' => 'email'])
                    </div>
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                            <input type="password" class="form-control" name="password" placeholder="password">
                        </div>
                        @include('layout.partials._error_message', ['field' => 'password'])
                        @include('layout.partials._error_message', ['field' => 'token'])
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Re-type password">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        {{ Form::submit('Reset password', ['class' => 'btn btn-mint text-uppercase']) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <div class="pad-ver">
                <a href="{{ route('login') }}" class="btn-link mar-rgt">Back to Login</a>
            </div>
        </div>
    </div>
@endsection
