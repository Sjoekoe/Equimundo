@extends('layout.app')

@section('content')
    <div class="grid-block medium-12">
        {{ Form::open(['route' => 'conversation.store']) }}
            {{ Form::label('to', trans('forms.labels.to')) }}
            {{ Form::text('to', $owner->fullName(), ['disabled']) }}
            {{ Form::hidden('contact_id', $owner->id) }}
            {{ Form::label('subject', trans('forms.labels.subject')) }}
            {{ Form::text('subject') }}
            {{ Form::label('message', trans('forms.labels.message')) }}
            {{ Form::textarea('message', null, ['class' => 'materialize-textarea']) }}
            {{ Form::submit(trans('forms.buttons.send'), ['class' => 'btn']) }}
        {{ Form::close() }}
    </div>
@stop
