@extends('layout.outer-app')

@section('content')
    <div class="passwordBox text-center loginscreen animated fadeInDown">
        <div class="ibox-content">
            @if (session()->has('status'))
                <p>{{ session()->get('status') }}</p>
            @endif
            {{ Form::open(['class' => 'm-t']) }}
                {{ Form::hidden('token', $token) }}
                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email">
                    @include('layout.partials._error_message', ['field' => 'email'])
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="password">
                    @include('layout.partials._error_message', ['field' => 'password'])
                    @include('layout.partials._error_message', ['field' => 'token'])
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Re-type password">
                </div>
                <div class="form-group text-right">
                    {{ Form::submit('Reset password', ['class' => 'btn btn-info']) }}
                </div>
            {{ Form::close() }}
            <br>
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
@endsection
