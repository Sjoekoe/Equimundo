@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div id="page-title">
        <h1 class="page-header text-overflow">{{ trans('copy.titles.create_palmares') }}</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    {{ Form::open(['route' => ['palmares.store', $horse->slug()], 'class' => 'grid-content medium-12', 'files' => true]) }}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {{ Form::label('event_name', trans('forms.labels.venue'), ['class' => 'control-label']) }}
                                        {{ Form::text('event_name', null, ['class' => 'form-control']) }}
                                        @include('layout.partials._error_message', ['field' => 'event_name'])
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('date', trans('forms.labels.date'), ['class' => 'control-label']) }}
                                        <div class="input-group date">
                                            {{ Form::text('date', null, ['placeholder' => 'dd/mm/YYYY', 'class' => 'form-control']) }}
                                            <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                                        </div>
                                        @include('layout.partials._error_message', ['field' => 'date'])
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {{ Form::label('discipline', trans('forms.labels.discipline'), ['class' => 'control-label']) }}
                                        {{ Form::select('discipline', trans('disciplines'), null, ['class' => 'form-control selectPicker', 'data-live-search' => true]) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('level', trans('forms.labels.category'), ['class' => 'control-label']) }}
                                        {{ Form::text('level', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {{ Form::label('ranking', trans('forms.labels.ranking'), ['class' => 'control-label']) }}
                                        {{ Form::text('ranking', null, ['class' => 'form-control']) }}
                                        @include('layout.partials._error_message', ['field' => 'ranking'])
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('body', trans('forms.labels.story'), ['class' => 'control-label']) }}
                                        {{ Form::textarea('body', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="row mar-top">
                                    <div class="col-sm-6 pad-no">
                                        <div class="image-upload">
                                            <label for="picture">
                                                <i class="btn btn-trans btn-icon fa fa-camera add-tooltip"></i>
                                            </label>

                                            {{ Form::file('picture', ['class' => 'pull-left', 'id' => 'picture']) }}
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn btn-mint']) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script>
        $('.input-group.date').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true
        });
    </script>
@stop
