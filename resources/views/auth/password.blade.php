@extends('layout.outer-app')

@section('content')
    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">
                    <h2 class="font-bold">Forgot password</h2>
                    <p>
                        Enter your email address to recover your password.
                    </p>
                    <div class="row">
                        <div class="col-lg-12">
                            {{ Form::open(['route' => 'password.post_forgot', 'class' => 'm-t']) }}
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email">
                                    @include('layout.partials._error_message', ['field' => 'email'])
                                </div>
                                {{ Form::submit('Send Password Reset Link', ['class' => 'btn btn-info']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Equimundo All rights reserved
            </div>
            <div class="col-md-6 text-right">
                <small>© {{ \Carbon\Carbon::now()->format('Y') }}</small>
            </div>
        </div>
    </div>
@endsection
