@extends('layout.app')

@section('content')
    <h3>{{ trans('copy.titles.settings') }}</h3>
    <div class="row">
        <a href="{{ route('password.edit') }}">{{ trans('copy.a.change_password') }}</a>
        {{ Form::open(['route', 'settings.update', 'method' => 'PUT']) }}
            <div class="input-field col s12">
                {{ Form::checkbox('email_notifications', 'email_notifications', Auth::user()->email_notifications, ['id' => 'email_notifications']) }}
                {{ Form::label('email_notifications', trans('forms.labels.email_notifications')) }}
            </div>
            <div class="input-field col s12">
                {{ Form::select('language', Config::get('languages'), Auth::user()->language) }}
                {{ Form::label('language', trans('forms.labels.language')) }}
            </div>
            {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn']) }}
        {{ Form::close() }}
    </div>

@stop
