@extends('layout.app')

@section('content')
    <div class="grid-content">
        <div class="grid-block medium-12">
            @include('layout.partials.errors')
            {{ Form::open(['route' => 'users.profiles.update', 'class' => 'form-horizontal']) }}

            {{ Form::label('first_name', trans('forms.labels.first_name')) }}
            {{ Form::text('first_name', auth()->user()->firstName()) }}

            {{ Form::label('last_name', trans('forms.labels.last_name')) }}
            {{ Form::text('last_name', auth()->user()->lastName()) }}

            {{ Form::label('date_of_birth', trans('forms.labels.date_of_birth')) }}
            {{ Form::text('date_of_birth', auth()->user()->dateOfBirth() ? eqm_date(auth()->user()->dateOfBirth()) : '', ['placeholder' => 'dd/mm/YYYY']) }}

            {{ Form::label('country', trans('forms.labels.country')) }}
            {{ Form::select('country', trans('countries'), auth()->user()->country()) }}

            {{ Form::label('gender', trans('forms.labels.gender')) }}
            {{ Form::select('gender', ['F' => 'Female', 'M' => 'Male'], auth()->user()->gender()) }}

            {{ Form::label('about', trans('forms.labels.about_you')) }}
            {{ Form::textarea('about', auth()->user()->about(), ['rows' => 3]) }}

            {{ Form::submit(trans('forms.buttons.save'), ['class' => 'button']) }}

            {{ Form::close() }}
        </div>
    </div>
@stop
