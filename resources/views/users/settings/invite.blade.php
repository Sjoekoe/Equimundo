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
                        {{ trans('copy.titles.invite_your_friends') }}
                    </h3>
                </div>
                {{ Form::open(['route', 'invite_friends.store', 'class' => 'form-horizontal']) }}
                <div class="panel-body">
                    <div class="alert alert-info fade in">
                        {{ trans('copy.p.invite_friends') }}
                    </div>
                    <select multiple name="emails[]" type="text" class="form-control" placeholder="Add a tag" data-role="tagsinput">
                </div>
                <div class="panel-footer text-right">
                    {{ Form::submit(trans('forms.buttons.invite'), ['class' => 'btn btn-info']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

