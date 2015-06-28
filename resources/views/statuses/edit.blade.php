@extends('layout.app')

@section('content')
    {{ Form::open(['route' => ['statuses.update', $status->id], 'method' => 'PUT']) }}
        {{ Form::hidden('horse', $status->horse->id) }}
        {{ Form::label('status', 'Status') }}
        {{ Form::textarea('status', $status->body) }}
        {{ Form::submit('Save', ['class' => 'btn']) }}
    {{ Form::close() }}
@stop
