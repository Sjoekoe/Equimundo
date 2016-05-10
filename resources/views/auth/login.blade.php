@extends('layout.outer-app')

@section('content')
    <div class="passwordBox text-center loginscreen animated fadeInDown">
        <div class="ibox-content">
            <h3>Welcome to Equimundo</h3>
            <p>The worlds premier social network for horses. </p>
            {{ Form::open(['route' => 'login', 'class' => 'm-t']) }}
                <div class="form-group">
                    {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'email']) }}
                    @include('layout.partials._error_message', ['field' => 'email'])
                </div>
                <div class="form-group">
                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'password']) }}
                    @include('layout.partials._error_message', ['field' => 'password'])
                </div>
                <div class="checkbox checkbox-info">
                    <input type="checkbox" name="remember">
                    <label> Remember Me </label>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="{{ route('password.forgot') }}"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('register') }}">Create an account</a>
            {{ Form::close() }}
            <p class="m-t"> <small>Equimundo All rights reserved © {{ \Carbon\Carbon::now()->format('Y') }}</small> </p>
        </div>
    </div>
@endsection
