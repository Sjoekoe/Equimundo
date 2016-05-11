@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    @if (auth()->check() && auth()->user()->isInHorseTeam($horse) && ! $album->isDefaultAlbum())
        <div class="row">
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
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h2 class="pull-left m-t-n-xs">
                        {{ $album->type() ? trans('albums.names.' . $album->type()) : $album->name() }}
                    </h2>
                    @if (auth()->check() && auth()->user()->isInHorseTeam($horse) && ! $album->isDefaultAlbum())
                        <div class="panel-control text-right">
                            <a href="{{ route('album.edit', $album->id()) }}" class="btn btn-info btn-xs">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="{{ route('album.delete', $album->id()) }}" class="btn btn-info btn-xs">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="panel-body">
                    <p>{{ $album->description() }}</p>
                    <div class="lightBoxGallery">
                        @foreach($album->pictures() as $picture)
                            <div class="col-md-2">
                                <div class="panel">
                                    <div class="panel-body">
                                        <a href="{{ route('file.picture', [$picture->id()]) }}" data-gallery>
                                            <img src="{{ route('file.picture', [$picture->id()]) }}" alt="" class="profile-image" style="max-height: 90px;">
                                        </a>
                                        <br>
                                        @if (auth()->check() && auth()->user()->isInHorseTeam($horse))
                                            <div class="text-right">
                                                @if (! $picture->profilePicture())
                                                    <a href="{{ route('horses.pictures.profile_picture', $picture->id()) }}" class="btn btn-info btn-outline btn-xs">
                                                        <i class="fa fa-bookmark-o"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('album.picture.delete', [$album->id(), $picture->id()]) }}" class="btn btn-info btn-xs">
                                                    <i class="fa fa-trash fa-lg fa-fw"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
