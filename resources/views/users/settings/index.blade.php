@extends('layout.app', ['title' => trans('copy.titles.settings'), 'pageTitle' => true])

@section('content')
    <div class="row">
        <div class="col-md-4">
            @include('users.partials._settings_navigation')
        </div>
        <div class="col-md-8">
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
                                {{ Form::checkbox('email_notifications', 'email_notifications', auth()->user()->email_notifications, ['id' => 'email_notifications', 'class' => 'js-switchery form-control']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('language', trans('forms.labels.language'), ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::select('language', config('languages'), auth()->user()->language(), ['class' => 'form-control selectPicker']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('timezone', trans('forms.labels.timezone'), ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::select('timezone', trans('timezones'), auth()->user()->timezone(), ['class' => 'form-control selectPicker']) }}
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn btn-info']) }}
                    </div>
                {{ Form::close() }}
            </div>
            <br>
            <div class="panel panel-bordered-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ trans('copy.titles.delete_account') }}
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="alert">
                        <div class="col-sm-6">
                            <p class="alert-message">
                                {{ trans('copy.p.delete_account') }}
                            </p>
                        </div>

                        <div class="text-right">
                            <a href="{{ route('users.delete') }}" class="btn btn-danger">{{ trans('copy.a.delete') }}</a>
                        </div>
                    </div>
                </div>
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
