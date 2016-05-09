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
                        {{ trans('copy.a.change_password') }}
                    </h3>
                </div>
                {{ Form::open(['class' => 'form-horizontal']) }}
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('old_password', trans('forms.labels.old_password'), ['class' => 'control-label col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::password('old_password', ['class' => 'form-control']) }}
                                @include('layout.partials._error_message', ['field' => 'old_password'])
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', trans('forms.labels.password'), ['class' => 'control-label col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::password('password', ['class' => 'form-control']) }}
                                @include('layout.partials._error_message', ['field' => 'password'])
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('password_confirmation', trans('forms.labels.password_confirmation'), ['class' => 'control-label col-sm-3']) }}
                            <div class="col-sm-9">
                                {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
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
