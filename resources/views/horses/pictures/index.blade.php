@extends('layout.app')

@section('content')
    @include('layout.partials.heading')

    @if (auth()->user()->isInHorseTeam($horse))
        <div class="row">
            <a href="{{ route('album.create', $horse->slug()) }}">{{ trans('copy.a.create_album') }}</a>
        </div>
    @endif

    <div class="row">
        <a href="{{ route('album.show', $horse->getStandardAlbum(\EQM\Models\Albums\Album::PROFILEPICTURES)) }}">
            {{ trans('albums.names')[\EQM\Models\Albums\Album::PROFILEPICTURES] }}
        </a>
        <a href="{{ route('album.show', $horse->getStandardAlbum(\EQM\Models\Albums\Album::TIMELINEPICTURES)) }}">
            {{ trans('albums.names')[\EQM\Models\Albums\Album::TIMELINEPICTURES] }}
        </a>
        <a href="{{ route('album.show', $horse->getStandardAlbum(\EQM\Models\Albums\Album::COVERPICTURES)) }}">
            {{ trans('albums.names')[\EQM\Models\Albums\Album::COVERPICTURES] }}
        </a>

        @if (count($albums))
            @foreach ($albums as $album)
                <a href="{{ route('album.show', $album->id()) }}">{{ $album->name() }}</a>
            @endforeach
        @endif

    </div>
@stop
