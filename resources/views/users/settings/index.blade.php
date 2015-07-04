@extends('layout.app')

@section('content')
    <h3>{{ trans('copy.titles.settings') }}</h3>
    <div class="row">
        {{ Form::open(['route', 'settings.update', 'method' => 'PUT']) }}
            <div class="input-field col s12">
                {{ Form::checkbox('email_notifications', 'email_notifications', Auth::user()->settings->email_notifications, ['id' => 'email_notifications']) }}
                {{ Form::label('email_notifications', trans('forms.labels.email_notifications')) }}
            </div>
            <div class="input-field col s12">
                {{ Form::select('language', Config::get('languages'), Auth::user()->settings->language) }}
                {{ Form::label('language', trans('forms.labels.language')) }}
            </div>
            {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn']) }}
        {{ Form::close() }}
    </div>

@stop

@section('footer')
    <script>
        $(document).ready(function() {
            $('select').material_select();
        });
    </script>
@stop
