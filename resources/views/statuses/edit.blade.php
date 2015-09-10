@extends('layout.app')

@section('content')
    {{ Form::open(['route' => ['statuses.update', $status->id()], 'method' => 'PUT']) }}
        {{ Form::hidden('horse', $status->horse()->id) }}
        {{ Form::label('status', trans('forms.labels.status')) }}
        {{ Form::textarea('status', $status->body()) }}
        {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn']) }}
    {{ Form::close() }}
@stop
