@extends('layout.app', ['title' => trans('copy.titles.create_horse'), 'pageTitle' => true])

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                {{ Form::open(['files' => true]) }}
                    <div class="panel-body">
                        <div class="alert alert-info">
                            <div class="media-body">
                                <h4 class="alert-title">
                                    {{ trans('copy.titles.get_the_most_of_equimundo') }}
                                </h4>
                                <p class="alert-message">
                                    {{ trans('copy.p.recommend_filling_in_the_password') }} <br>
                                    {{ trans('copy.p.entering_th_life_number') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    {{ Form::label('name', trans('forms.labels.name') . '*', ['class' => 'control-label']) }}
                                    {{ Form::text('name', null, ['class' => 'form-control']) }}
                                    @include('layout.partials._error_message', ['field' => 'name'])
                                </div>
                                <div class="form-group">
                                    {{ Form::label('date_of_birth', trans('forms.labels.date_of_birth'), ['class' => 'control-label']) }}
                                    <div class="input-group date">
                                        {{ Form::text('date_of_birth', null, ['placeholder' => 'dd/mm/yyyy', 'class' => 'form-control']) }}
                                        <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                                    </div>
                                    @include('layout.partials._error_message', ['field' => 'date_of_birth'])
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    {{ Form::label('height', trans('forms.labels.height'), ['class' => 'control-label']) }}
                                    {{ Form::select('height', config('heights.eur'), null, ['class' => 'form-control selectPicker']) }}
                                    @include('layout.partials._error_message', ['field' => 'height'])
                                </div>
                                <div class="form-group">
                                    {{ Form::label('life_number', trans('forms.labels.life_number'), ['class' => 'control-label']) }}
                                    {{ Form::text('life_number', null, ['class' => 'form-control']) }}
                                    @include('layout.partials._error_message', ['field' => 'life_number'])
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    {{ Form::label('gender', trans('forms.labels.gender'), ['class' => 'control-label']) }}
                                    {{ Form::select('gender', trans('horses.genders'), null, ['class' => 'form-control selectPicker']) }}
                                    @include('layout.partials._error_message', ['field' => 'gender'])
                                </div>
                                <div class="form-group">
                                    {{ Form::label('breed', trans('forms.labels.breed'), ['class' => 'control-label']) }}
                                    {{ Form::select('breed', trans('horses.breeds'), null, ['class' => 'form-control selectPicker', 'data-live-search' => true]) }}
                                    @include('layout.partials._error_message', ['field' => 'breed'])
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    {{ Form::label('color', trans('forms.labels.color'), ['class' => 'control-label']) }}
                                    {{ Form::select('color', trans('horses.colors'), null, ['class' => 'form-control selectPicker']) }}
                                    @include('layout.partials._error_message', ['field' => 'color'])
                                </div>
                                <div class="form-group">
                                    {{ Form::label('profile_pic', trans('forms.labels.profile_picture'), ['class' => 'control-label']) }}
                                    <br>
                                    <span class="pull-left btn btn-mint btn-file">
                                        {{ trans('copy.span.file') }} <input type="file" name="profile_pic">
                                    </span>
                                    @include('layout.partials._error_message', ['field' => 'profile_pic'])
                                </div>
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
@stop

@section('footer')
    <script>
        $('.input-group.date').datepicker({
            format: 'dd/mm/yyyy',
            autoclose:true
        });
    </script>
@stop
