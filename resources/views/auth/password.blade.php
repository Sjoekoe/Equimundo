@extends('layout.outer-app')

@section('content')

<div id="container" class="cls-container">
    <div id="bg-overlay" class="bg-img" style="background-image: url({{ asset('images/horses.jpg') }})"></div>

    @include('layout.partials._outer_app_header')

    <div class="cls-content">
        <div class="cls-content-sm panel">
            <div class="panel-body">
                <p class="pad-btm">Enter your email address to recover your password.</p>
                {{ Form::open(['route' => 'password.post_forgot', 'class' => 'form-horizontal']) }}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email">
                    </div>
                    @include('layout.partials._error_message', ['field' => 'email'])
                </div>
                <div class="form-group text-right">
                    {{ Form::submit('Send Password Reset Link', ['class' => 'btn btn-mint text-uppercase']) }}
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
