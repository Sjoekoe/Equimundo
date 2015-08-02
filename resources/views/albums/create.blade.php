@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="row">
        {{ Form::open(['route' => ['album.store', $horse->slug], 'files' => true]) }}
            {{ Form::label('name', trans('forms.labels.name')) }}
            {{ Form::text('name') }}
            {{ Form::label('description', trans('forms.labels.description')) }}
            {{ Form::textarea('description') }}
            {{ Form::file('pictures[]', ['multiple' => 'true']) }}
            {{ Form::submit(trans('forms.buttons.save', ['class' => 'btn'])) }}
        {{ Form::close() }}
    </div>
@stop
