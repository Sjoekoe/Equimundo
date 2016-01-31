@extends('layout.app')

@section('content')
    <div id="page-content">
        <div class="col-md-2 col-md-offset-2">
            @include('users.partials._settings_navigation')
        </div>
        <div class="col-md-4">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ trans('copy.titles.settings') }}
                    </h3>
                </div>
                {{ Form::open(['route', 'settings.update', 'method' => 'PUT', 'class' => 'form-horizontal']) }}
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('email_notifications', trans('forms.labels.email_notifications'), ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::checkbox('email_notifications', 'email_notifications', Auth::user()->email_notifications, ['id' => 'email_notifications', 'class' => 'js-switchery form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('language', trans('forms.labels.language'), ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::select('language', config('languages'), Auth::user()->language(), ['class' => 'form-control selectPicker']) }}
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn btn-info']) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script>
        var elem = document.querySelector('.js-switchery');
        var init = new Switchery(elem, {color:'#2cd0a7'});
    </script>
@stop
