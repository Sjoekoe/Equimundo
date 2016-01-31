@extends('layout.app')

@section('content')
    <div id="page-title">
        <h1 class="page-header text-overflow">{{ trans('copy.titles.edit_profile') }}</h1>
    </div>
    <div id="page-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    {{ Form::open(['route' => 'users.profiles.update']) }}
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {{ Form::label('first_name', trans('forms.labels.first_name'), ['class' => 'control-label']) }}
                                        {{ Form::text('first_name', auth()->user()->firstName(), ['class' => 'form-control']) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('last_name', trans('forms.labels.last_name'), ['class' => 'control-label']) }}
                                        {{ Form::text('last_name', auth()->user()->lastName(), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {{ Form::label('date_of_birth', trans('forms.labels.date_of_birth'), ['class' => 'control-label']) }}
                                        <div class="input-group date">
                                            {{ Form::text('date_of_birth', auth()->user()->dateOfBirth() ? eqm_date(auth()->user()->dateOfBirth()) : '', ['placeholder' => 'dd/mm/YYYY', 'class' => 'form-control']) }}
                                            <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('country', trans('forms.labels.country'), ['class' => 'control-label']) }}
                                        {{ Form::select('country', trans('countries'), auth()->user()->country(), ['class' => 'form-control selectPicker']) }}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {{ Form::label('gender', trans('forms.labels.gender'), ['class' => 'control-label']) }}
                                        {{ Form::select('gender', ['F' => 'Female', 'M' => 'Male'], auth()->user()->gender(), ['class' => 'form-control selectPicker']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('about', trans('forms.labels.about_you'), ['class' => 'control-label']) }}
                                        {{ Form::textarea('about', auth()->user()->about(), ['rows' => 3, 'class' => 'form-control']) }}
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
