@extends('layout.app')

@section('content')
    <div class="col-md-8 col-md-offset-2">
        {{ Form::open(['class' => 'form-horizontal']) }}
            <div class="form-group">
                {{ Form::label('old_password', trans('forms.labels.old_password'), ['class' => 'control-label col-md-2']) }}
                {{ Form::password('old_password', ['class' => 'form-control col-md-4']) }}
            </div>
            <div class="form-group">
                {{ Form::label('password', trans('forms.labels.password'), ['class' => 'control-label col-md-2']) }}
                {{ Form::password('password', ['class' => 'form-control col-md-4']) }}
            </div>
            <div class="form-group">
                {{ Form::label('password_confirmation', trans('forms.labels.password_confirmation'), ['class' => 'control-label col-md-2']) }}
                {{ Form::password('password_confirmation', ['class' => 'form-control col-md-4']) }}
            </div>
            {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
    </div>
@stop
