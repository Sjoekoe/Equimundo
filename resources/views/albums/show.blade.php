@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div id="page-content">
        <div class="col-sm-12 col-lg-8 col-lg-offset-2">
            @if (auth()->check() && auth()->user()->isInHorseTeam($horse) && ! $album->isDefaultAlbum())
                <div class="panel">
                    <div class="panel-body">
                        {{ Form::open(['route' => ['album.picture.store', $album->id()], 'files' => true]) }}
                            <div class="col-md-4">
                                {{ Form::file('pictures[]', ['multiple' => 'true']) }}
                            </div>
                            <div class="col-md-6">
                                {{ form::submit('upload', ['class' => 'btn btn-info']) }}
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            @endif
            <div class="panel">
                <div class="panel-heading">
                    @if (auth()->check() && auth()->user()->isInHorseTeam($horse) && ! $album->isDefaultAlbum())
                        <div class="panel-control">
                            <a href="{{ route('album.edit', $album->id()) }}" class="btn btn-default">
                                <i class="fa fa-pencil fa-lg fa-fw"></i>
                            </a>
                            <a href="{{ route('album.delete', $album->id()) }}" class="btn btn-default">
                                <i class="fa fa-trash fa-lg fa-fw"></i>
                            </a>
                        </div>
                    @endif
                    <h3 class="panel-title">
                        {{ $album->type() ? trans('albums.names.' . $album->type()) : $album->name() }}
                    </h3>
                </div>
                <div class="panel-body">
                    <p>{{ $album->description() }}</p>
                    @foreach ($album->pictures() as $picture)
                        <div class="col-md-4">
                            <div class="thumbnail">
                                <a href="{{ route('file.picture', [$picture->id()]) }}" data-lightbox="{{ $album->id() }}">
                                    <img src="{{ route('file.picture', [$picture->id()]) }}" alt="" class="img-responsive" style="height: 240px;">
                                </a>
                                @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                                    <div class="caption text-right">
                                        @if (! $picture->profilePicture())
                                            <a href="{{ route('horses.pictures.profile_picture', $picture->id()) }}" class="btn btn-purple">
                                                <i class="fa fa-bookmark-o fa-lg fa-fw"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('album.picture.delete', [$album->id(), $picture->id()]) }}" class="btn btn-info">
                                            <i class="fa fa-trash fa-lg fa-fw"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
