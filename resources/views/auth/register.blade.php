@extends('layout.outer-app')

@section('content')
    <div class="passwordBox text-center loginscreen animated fadeInDown">
        <div class="ibox-content">
            <h3>Welcome to Equimundo</h3>
            <p>The worlds premier social network for horses.</p>
            {{ Form::open(['class' => 'm-t']) }}
                <div class="form-group">
                    {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First name']) }}
                    @include('layout.partials._error_message', ['field' => 'first_name'])
                </div>
                <div class="form-group">
                    {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last name']) }}
                    @include('layout.partials._error_message', ['field' => 'last_name'])
                </div>
                <div class="form-group">
                    {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'E-mail']) }}
                    @include('layout.partials._error_message', ['field' => 'email'])
                </div>
                <div class="form-group">
                    <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        {{ Form::text('date_of_birth', null, ['placeholder' => 'date of birth - dd/mm/yyyy', 'class' => 'form-control']) }}
                        @include('layout.partials._error_message', ['field' => 'date_of_birth'])
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::select('country', trans('countries'), '', ['class' => 'form-control selectPicker', 'tabindex' => 5]) }}
                </div>
                <div class="form-group">
                    <div class="radio radio-info radio-inline">
                        <input type="radio" checked name="gender" value="F">
                        <label> Female </label>
                    </div>
                    <div class="radio radio-info radio-inline">
                        <input type="radio" name="gender" value="M">
                        <label> Male </label>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                    @include('layout.partials._error_message', ['field' => 'password'])
                </div>
                <div class="form-group">
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) }}
                    @include('layout.partials._error_message', ['field' => 'password_confirmation'])
                </div>
                <div class="form-group">
                    <div class="checkbox checkbox-info">
                        <input type="checkbox" name="terms">
                        <label> Agree the <a href="{{ route('terms_of_service') }}">terms and policy </a></label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('login') }}">Login</a>
            {{ Form::close() }}
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
