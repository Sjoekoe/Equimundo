@extends('layout.app')

@section('content')
    <div class="row">
        {{ Form::open(['album.update', 'method' => 'PUT']) }}
            {{ Form::label('name', trans('forms.labels.name')) }}
            {{ Form::text('name', $album->name) }}
            {{ Form::label('description', trans('forms.labels.description')) }}
            {{ Form::textarea('description', $album->description) }}
            {{ Form::submit(trans('forms.buttons.save')) }}
        {{ Form::close() }}
    </div>
@stop
