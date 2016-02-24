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
                                    {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First name', 'tabindex' => 1]) }}
                                </div>
                                @include('layout.partials._error_message', ['field' => 'first_name'])
                            </div>
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                    {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'E-mail', 'tabindex' => 3]) }}
                                </div>
                                @include('layout.partials._error_message', ['field' => 'email'])
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                    {{ Form::select('interests[]', ['Owner', 'Enthousiast', 'Professional', 'Breeder', 'Athlete'], '', ['multiple' => true, 'class' => 'selectPicker form-control', 'title' => 'My business in horses...', 'tabindex' => 5]) }}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'tabindex' => 8]) }}
                                </div>
                                @include('layout.partials._error_message', ['field' => 'password'])
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-male"></i></div>
                                    {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last name', 'tabindex' => 2]) }}
                                </div>
                                @include('layout.partials._error_message', ['field' => 'last_name'])
                            </div>
                            <div class="form-group {{ $errors->has('date_of_birth') ? 'has-error' : '' }}">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                                    {{ Form::text('date_of_birth', null, ['placeholder' => 'dd/mm/yyyy', 'class' => 'form-control', 'tabindex' => 4]) }}
                                </div>
                                @include('layout.partials._error_message', ['field' => 'date_of_birth'])
                            </div>
                            <div class="form-group" style="height: 31px;">
                                <div class="radio">
                                    <label class="form-radio form-icon form-text active" tabindex="6">
                                        <input type="radio" name="gender" value="F">
                                        Female
                                    </label>
                                    <label class="form-radio form-icon form-text active" tabindex="7">
                                        <input type="radio" name="gender" value="M">
                                        Male
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password', 'tabIndex' => 9]) }}
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

@section('footer')
    <script>
        $('.input-group.date').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true
        });
    </script>
@stop
