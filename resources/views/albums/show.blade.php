@extends('layout.app')

@section('content')
    @include('layout.partials.heading')

    <h3>{{ $album->type() ? trans('albums.names.' . $album->type()) : $album->name() }}</h3>
    <p>{{ $album->description() }}</p>
    @if (auth()->user()->isInHorseTeam($horse))
        <div class="row">
            {{ Form::open(['route' => ['album.picture.store', $album->id()], 'files' => true]) }}
                {{ Form::label('pictures[]', trans('forms.labels.add_pictures')) }}
                {{ Form::file('pictures[]', ['multiple' => true]) }}
                {{ Form::submit(trans('forms.labels.add_pictures')) }}
            {{ Form::close() }}

            <a href="{{ route('album.delete', $album->id()) }}">{{ trans('copy.a.delete_album') }}</a>
            <a href="{{ route('album.edit', $album->id()) }}">{{ trans('copy.a.edit_album') }}</a>
        </div>
    @endif


    <div class="row">
        @foreach ($album->pictures() as $picture)
            <img src="{{ route('file.picture', [$picture->id()]) }}" alt=""/>
            <a href="{{ route('album.picture.delete', [$album->id(), $picture->id()]) }}">{{ trans('copy.a.delete_picture') }}</a>
        @endforeach
    </div>
@stop
