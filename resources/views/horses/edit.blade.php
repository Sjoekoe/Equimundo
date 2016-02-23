@extends('layout.app')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">
            {{ trans('copy.titles.edit') }} {{ $horse->name() }}
        </h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{ Form::open(['route' => ['horses.edit', $horse->slug()], 'class' => 'col s12', 'files' => 'true', 'method' => 'put']) }}
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {{ Form::label('name', trans('forms.labels.name'), ['class' => 'control-label']) }}
                                        {{ Form::text('name', $horse->name(), ['class' => 'form-control']) }}
                                        @include('layout.partials._error_message', ['field' => 'name'])
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('date_of_birth', trans('forms.labels.date_of_birth'), ['class' => 'control-label']) }}
                                        <div class="input-group date">
                                            {{ Form::text('date_of_birth', eqm_date($horse->dateOfBirth()), ['placeholder' => 'dd/mm/yyyy', 'class' => 'form-control']) }}
                                            <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                                            @include('layout.partials._error_message', ['field' => 'date_of_birth'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {{ Form::label('height', trans('forms.labels.height'), ['class' => 'control-label']) }}
                                        {{ Form::select('height', config('heights.eur'), $horse->height(), ['class' => 'form-control selectPicker']) }}
                                        @include('layout.partials._error_message', ['field' => 'height'])
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('life_number', trans('forms.labels.life_number'), ['class' => 'control-label']) }}
                                        {{ Form::text('life_number', $horse->lifeNumber(), ['class' => 'form-control']) }}
                                        @include('layout.partials._error_message', ['field' => 'life_number'])
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {{ Form::label('gender', trans('forms.labels.gender'), ['class' => 'control-label']) }}
                                        {{ Form::select('gender', trans('horses.genders'), $horse->gender(), ['class' => 'form-control selectPicker']) }}
                                        @include('layout.partials._error_message', ['field' => 'gender'])
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('breed', trans('forms.labels.breed'), ['class' => 'control-label']) }}
                                        {{ Form::select('breed', trans('horses.breeds'), $horse->breed(), ['class' => 'form-control selectPicker', 'data-live-search' => true]) }}
                                        @include('layout.partials._error_message', ['field' => 'breed'])
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {{ Form::label('color', trans('forms.labels.color'), ['class' => 'control-label']) }}
                                        {{ Form::select('color', trans('horses.colors'), $horse->color(), ['class' => 'form-control selectPicker']) }}
                                        @include('layout.partials._error_message', ['field' => 'color'])
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-3">
                                    {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn btn-mint']) }}
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
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
