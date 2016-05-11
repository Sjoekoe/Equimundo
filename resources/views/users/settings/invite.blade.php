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
                        {{ trans('copy.titles.invite_your_friends') }}
                    </h3>
                </div>
                {{ Form::open(['route', 'invite_friends.store', 'class' => 'form-horizontal']) }}
                <div class="panel-body">
                    <div class="alert alert-info fade in">
                        {{ trans('copy.p.invite_friends') }}
                    </div>
                    <select multiple name="emails[]" type="text" class="form-control" placeholder="Add email addresses..." data-role="tagsinput">
                </div>
                <div class="panel-footer text-right">
                    {{ Form::submit(trans('forms.buttons.invite'), ['class' => 'btn btn-info']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

