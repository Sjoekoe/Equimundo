@extends('layout.app')

@section('content')
    <div id="page-content">
        <div class="col-md-2 col-md-offset-2">
            @include('users.partials._settings_navigation')
        </div>
        <div class="col-md-4">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ trans('copy.a.edit_profile') }}
                    </h3>
                </div>
                {{ Form::open(['route' => 'users.profiles.update', 'class' => 'form-horizontal']) }}
                    <div class="panel-body">
                        <div class="form-group">
                            {{ Form::label('first_name', trans('forms.labels.first_name'), ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::text('first_name', auth()->user()->firstName(), ['class' => 'form-control']) }}
                                @include('layout.partials._error_message', ['field' => 'first_name'])
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('last_name', trans('forms.labels.last_name'), ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::text('last_name', auth()->user()->lastName(), ['class' => 'form-control']) }}
                                @include('layout.partials._error_message', ['field' => 'last_name'])
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('date_of_birth', trans('forms.labels.date_of_birth'), ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                <div class="input-group date">
                                    {{ Form::text('date_of_birth', auth()->user()->dateOfBirth() ? eqm_date(auth()->user()->dateOfBirth()) : '', ['placeholder' => 'dd/mm/YYYY', 'class' => 'form-control']) }}
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                                </div>
                                @include('layout.partials._error_message', ['field' => 'date_of_birth'])
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('country', trans('forms.labels.country'), ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::select('country', trans('countries'), auth()->user()->country(), ['class' => 'form-control selectPicker']) }}
                                @include('layout.partials._error_message', ['field' => 'country'])
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('gender', trans('forms.labels.gender'), ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::select('gender', ['F' => trans('forms.copy.female'), 'M' => trans('forms.copy.male')], auth()->user()->gender(), ['class' => 'form-control selectPicker']) }}
                                @include('layout.partials._error_message', ['field' => 'gender'])
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('website', 'Website', ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::text('website', auth()->user()->website(), ['placeholder' => 'https://www.equimundo.com', 'class' => 'form-control']) }}
                                @include('layout.partials._error_message', ['field' => 'website'])
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('facebook', 'Facebook', ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::text('facebook', auth()->user()->facebook(), ['class' => 'form-control', 'placeholder' => 'username']) }}
                                @include('layout.partials._error_message', ['field' => 'facebook'])
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('twitter', 'Twitter', ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::text('twitter', auth()->user()->twitter(), ['class' => 'form-control', 'placeholder' => 'username']) }}
                                @include('layout.partials._error_message', ['field' => 'twitter'])
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('about', trans('forms.labels.about_you'), ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::textarea('about', auth()->user()->about(), ['rows' => 3, 'class' => 'form-control']) }}
                                @include('layout.partials._error_message', ['field' => 'about'])
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
