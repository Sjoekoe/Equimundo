@extends('layout.outer-app')

@section('content')

<div id="container" class="cls-container">
    <div id="bg-overlay" class="bg-img" style="background-image: url({{ asset('images/horses.jpg') }})"></div>

    @include('layout.partials._outer_app_header')

    <div class="cls-content">
        <div class="cls-content-lg panel">
            <div class="panel-body">
                <p class="pad-btm">Create an account</p>
                {{ Form::open(['class' => 'form-horizontal']) }}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                    <div class="input-group-addon"><i class="fa fa-male"></i></div>
                                    {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First name']) }}
                                </div>
                                @include('layout.partials._error_message', ['field' => 'first_name'])
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                                </div>
                                @include('layout.partials._error_message', ['field' => 'password'])
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-male"></i></div>
                                    {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last name']) }}
                                </div>
                                @include('layout.partials._error_message', ['field' => 'last_name'])
                            </div>
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                    {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'E-mail']) }}
                                </div>
                                @include('layout.partials._error_message', ['field' => 'email'])
                            </div>
                            <div class="form-group">
                                <div class="radio">
                                    <label class="form-radio form-icon form-text active">
                                        <input type="radio" checked name="gender" value="F">
                                        Female
                                    </label>
                                    <label class="form-radio form-icon form-text active">
                                        <input type="radio" name="gender" value="M">
                                        Male
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 text-left checkbox">
                            <label class="form-checkbox form-icon">
                                <input type="checkbox" name="terms"> I agree with the <a href="{{ route('terms_of_service') }}" target="_blank" class="mint-anchor">Terms and Conditions</a>
                            </label>
                            @include('layout.partials._error_message', ['field' => 'terms'])
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group text-right">
                                <button class="btn btn-mint text-uppercase" type="submit">Register</button>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
        <div class="pad-ver">
            Already have an account ? <a href="{{ route('login') }}" class="btn-link mar-rgt">Sign In</a>
        </div>
    </div>
</div>
@endsection
