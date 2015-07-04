@extends('layout.app')

@section('content')
    @include('layout.partials.errors')

    {{ Form::open(['route' => 'login', 'class' => 'form-horizontal']) }}

    <!-- Email Form input -->
    <div class="form-group">
        {{ Form::label('email', trans('forms.labels.email'), ['class' => 'col-md-4 control-label']) }}
        <div class="col-md-6">
            {{ Form::text('email', null, ['class' => 'form-control']) }}
        </div>
    </div>

    <!-- Password Form input -->
    <div class="form-group">
        {{ Form::label('password', trans('forms.labels.password'), ['class' => 'col-md-4 control-label']) }}
        <div class="col-md-6">
            {{ Form::password('password', ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <div class="checkbox">
                <label>
                    {{ Form::checkbox('remember', 'Remember Me') }}
                    {{ trans('forms.copy.remember') }}
                </label>
            </div>
        </div>
    </div>

    <!-- Submit button -->
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {{ Form::submit(trans('forms.buttons.login'), ['class' => 'btn btn-default', 'style' => 'margin-right:
            15px;']) }}
            <a href="/password/email">Forgot Your Password?</a>
        </div>
    </div>

    {{ Form::close() }}
@endsection
