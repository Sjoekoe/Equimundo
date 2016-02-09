@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div id="page-content">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                       {{ trans('copy.a.create_album') }}
                    </h3>
                </div>
                {{ Form::open(['route' => ['album.store', $horse->slug()], 'files' => true]) }}
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('name', trans('forms.labels.name'), ['class' => 'control-label']) }}
                            {{ Form::text('name', null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('description', trans('forms.labels.description'), ['class' => 'control-label']) }}
                            {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::file('pictures[]', ['multiple' => 'true']) }}
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
