@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div id="page-content">
        <div class="col-lg-7 col-lg-offset-2">
            @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                <div class="row">
                    <div class="col-sx-3 pull-right">
                        <a href="{{ route('album.create', $horse->slug()) }}" class="btn btn-info">{{ trans('copy.a.create_album') }}</a>
                    </div>
                </div>
                <br>
            @endif

            <div class="row">
                <?php $album = $horse->getStandardAlbum(\EQM\Models\Albums\Album::PROFILEPICTURES) ?>
                @if ($album)
                    @include('albums._partials._thumbnail', ['name' => trans('albums.names.' . \EQM\Models\Albums\Album::PROFILEPICTURES)])
                @endif
                <?php $album = $horse->getStandardAlbum(\EQM\Models\Albums\Album::TIMELINEPICTURES) ?>
                @if ($album)
                    @include('albums._partials._thumbnail', ['name' => trans('albums.names.' . \EQM\Models\Albums\Album::TIMELINEPICTURES)])
                @endif
                <?php $album = $horse->getStandardAlbum(\EQM\Models\Albums\Album::COVERPICTURES) ?>
                @if ($album)
                    @include('albums._partials._thumbnail', ['name' => trans('albums.names.' . \EQM\Models\Albums\Album::COVERPICTURES)])
                @endif
            </div>
            <div class="row">
                @if (count($albums))
                    @foreach ($albums as $album)
                        @include('albums._partials._thumbnail')
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop
