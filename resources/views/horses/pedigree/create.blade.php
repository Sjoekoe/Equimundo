@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="row">
        <div class="col-md-12">
            <div id="page-content">
                <div class="panel">
                    {{ Form::open(['route' => ['pedigree.store', $horse->slug()]]) }}
                    {{ Form::hidden('type', Input::get('type')) }}
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('name', trans('forms.labels.name'), ['class' => 'control-label']) }}
                                    {{ Form::text('name', null, ['class' => 'form-control']) }}
                                    @include('layout.partials._error_message', ['field' => 'name'])
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('color', trans('forms.labels.color'), ['class' => 'control-label']) }}
                                    {{ Form::select('color', trans('horses.colors'), null, ['class' => 'form-control selectPicker']) }}
                                    @include('layout.partials._error_message', ['field' => 'color'])
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {{ Form::label('breed', trans('forms.labels.breed'), ['class' => 'control-label']) }}
                                    {{ Form::select('breed', trans('horses.breeds'), null, ['class' => 'form-control selectPicker']) }}
                                    @include('layout.partials._error_message', ['field' => 'breed'])
                                </div>
                            </div>
                            <div class="col-sm-6">
                                {{ Form::label('height', trans('forms.labels.height'), ['class' => 'control-label']) }}
                                {{ Form::select('height', config('heights.eur'), null, ['class' => 'form-control selectPicker']) }}
                                @include('layout.partials._error_message', ['field' => 'height'])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                {{ Form::label('date_of_birth', trans('forms.labels.date_of_birth'), ['class' => 'control-label']) }}
                                <div class="input-group date">
                                    {{ Form::text('date_of_birth', null, ['placeholder' => 'yyyy', 'class' => 'form-control']) }}
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                                </div>
                                @include('layout.partials._error_message', ['field' => 'date_of_birth'])
                            </div>
                            <div class="col-sm-6">
                                {{ Form::label('life_number', trans('forms.labels.life_number'), ['class' => 'control-label']) }}
                                {{ Form::text('life_number', null, ['class' => 'form-control']) }}
                                @include('layout.partials._error_message', ['field' => 'life_number'])
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn btn-info']) }}
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
            format: 'yyyy',
            autoclose:true
        });
    </script>
@stop
