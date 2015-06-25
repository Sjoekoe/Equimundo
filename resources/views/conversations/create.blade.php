@extends('layout.app')

@section('content')
    <div class="grid-block medium-12">
        {{ Form::open(['route' => 'conversation.store']) }}
            {{ Form::label('to') }}
            {{ Form::text('to', $owner->username, ['disabled']) }}
            {{ Form::hidden('contact_id', $owner->id) }}
            {{ Form::label('subject') }}
            {{ Form::text('subject') }}
            {{ Form::label('message') }}
            {{ Form::textarea('message', null, ['class' => 'materialize-textarea']) }}
            {{ Form::submit('Send', ['class' => 'btn']) }}
        {{ Form::close() }}
    </div>
@stop
