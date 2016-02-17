@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div id="page-content">
        <div class="col-sm-12 col-lg-8 col-lg-offset-2">
            <div class="panel">
                <div class="panel-heading">
                    @if (auth()->user()->isInHorseTeam($horse))
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
                                @if (auth()->user()->isInHorseTeam($horse))
                                    <div class="caption text-right">
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

    {{--@if (auth()->user()->isInHorseTeam($horse))
        <div class="row">
            {{ Form::open(['route' => ['album.picture.store', $album->id()], 'files' => true]) }}
                {{ Form::label('pictures[]', trans('forms.labels.add_pictures')) }}
                {{ Form::file('pictures[]', ['multiple' => true]) }}
                {{ Form::submit(trans('forms.labels.add_pictures')) }}
            {{ Form::close() }}

            <a href="{{ route('album.delete', $album->id()) }}">{{ trans('copy.a.delete_album') }}</a>
            <a href="{{ route('album.edit', $album->id()) }}">{{ trans('copy.a.edit_album') }}</a>
        </div>
    @endif--}}
@stop
