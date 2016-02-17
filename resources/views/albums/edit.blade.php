@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div id="page-content">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ trans('copy.a.edit_album') }}
                    </h3>
                </div>
                {{ Form::open(['route' => ['album.update', $album->id()], 'method' => 'PUT']) }}
                <div class="panel-body">
                    <div class="form-group">
                        {{ Form::label('name', trans('forms.labels.name'), ['class' => 'control-label']) }}
                        {{ Form::text('name', $album->type() ? trans('albums.names.' . $album->type()) : $album->name(), ['class' => 'form-control', $album->type() ? 'disabled' : '']) }}
                        @if ($album->type())
                            {{ Form::hidden('name', $album->name()) }}
                        @endif
                        @include('layout.partials._error_message', ['field' => 'name'])
                    </div>
                    <div class="form-group">
                        {{ Form::label('description', trans('forms.labels.description'), ['class' => 'control-label']) }}
                        {{ Form::textarea('description', $album->description(), ['class' => 'form-control']) }}
                        @include('layout.partials._error_message', ['field' => 'description'])
                    </div>
                </div>
                <div class="panel-footer text-right">
                    {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn btn-info']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
