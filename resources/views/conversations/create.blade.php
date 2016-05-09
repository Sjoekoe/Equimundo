@extends('layout.app', ['title' => trans('copy.titles.send_message', ['receiver' => $owner->fullName()]), 'pageTitle' => true])

@section('content')
    <div class="row">
        <div class="panel">
            {{ Form::open(['route' => 'conversation.store', 'class' => 'form-horizontal']) }}
                <div class="panel-body">
                    <div class="form-group">
                        {{ Form::label('to', trans('forms.labels.to'), ['class' => 'col-sm-2 control-label']) }}
                        <div class="col-sm-10">
                            {{ Form::text('to', $owner->fullName(), ['disabled', 'class' => 'form-control']) }}
                        </div>
                    </div>
                    {{ Form::hidden('contact_id', $owner->id()) }}
                    <div class="form-group">
                        {{ Form::label('subject', trans('forms.labels.subject'), ['class' => 'col-sm-2 control-label']) }}
                        <div class="col-sm-10">
                            {{ Form::text('subject', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('message', trans('forms.labels.message'), ['class' => 'col-sm-2 control-label']) }}
                        <div class="col-sm-10">
                            {{ Form::textarea('message', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    {{ Form::submit(trans('forms.buttons.send'), ['class' => 'btn btn-info']) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
@stop
