@extends('layout.app')

@section('content')
    <div class="grid-content">
        <div class="grid-block medium-12">
            @include('layout.partials.errors')
            {{ Form::open(['route' => 'users.profiles.update', 'class' => 'form-horizontal']) }}

            {{ Form::label('first_name', trans('forms.labels.first_name')) }}
            {{ Form::text('first_name', Auth::user()->first_name) }}

            {{ Form::label('last_name', trans('forms.labels.last_name')) }}
            {{ Form::text('last_name', Auth::user()->last_name) }}

            {{ Form::label('date_of_birth', trans('forms.labels.date_of_birth')) }}
            {{ Form::text('date_of_birth', Auth::user()->dateOfBirth()->format('d/m/Y'), ['placeholder' => 'dd/mm/YYYY']) }}

            {{ Form::label('country', trans('forms.labels.country')) }}
            {{ Form::select('country', Lang::get('countries'), Auth::user()->country) }}

            {{ Form::label('gender', trans('forms.labels.gender')) }}
            {{ Form::select('gender', ['F' => 'Female', 'M' => 'Male'], Auth::user()->gender) }}

            {{ Form::label('about', trans('forms.labels.about_you')) }}
            {{ Form::textarea('about', Auth::user()->about, ['rows' => 3]) }}

            {{ Form::submit(trans('forms.buttons.save'), ['class' => 'button']) }}

            {{ Form::close() }}
        </div>
    </div>
@stop
