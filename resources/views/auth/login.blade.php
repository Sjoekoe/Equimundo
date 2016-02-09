@extends('layout.outer-app')

@section('content')
<div id="container" class="cls-container">
    <div id="bg-overlay" class="bg-img" style="background-image: url({{ asset('images/horses.jpg') }})"></div>
    @include('layout.partials._outer_app_header')
    <div class="cls-content">
        <div class="cls-content-sm panel">
            <div class="panel-body">
                <p class="pad-btm">Sign In to your account</p>
                {{ Form::open(['route' => 'login', 'class' => 'form-horizontal']) }}
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                            {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'email']) }}
                        </div>
                        @include('layout.partials._error_message', ['field' => 'email'])
                    </div>
                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'password']) }}
                        </div>
                        @include('layout.partials._error_message', ['field' => 'password'])
                    </div>
                    <div class="row">
                        <div class="col-xs-8 text-left checkbox">
                            <label class="form-checkbox form-icon">
                                <input type="checkbox" name="remember"> Remember me
                            </label>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group text-right">
                                {{ Form::submit(trans('forms.buttons.login'), ['class' => 'btn btn-mint text-uppercase']) }}
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
        <div class="pad-ver">
            <a href="{{ route('password.forgot') }}" class="btn-link mar-rgt">Forgot password ?</a>
            <a href="{{ route('register') }}" class="btn-link mar-lft">Create a new account</a>
        </div>
    </div>
</div>
@endsection
