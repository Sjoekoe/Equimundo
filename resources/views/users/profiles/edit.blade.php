@extends('layout.app')

@section('content')
    <div class="grid-content">
        <div class="grid-block medium-12">
            @include('layout.partials.errors')
            {{ Form::open(['route' => 'users.profiles.update', 'class' => 'form-horizontal']) }}

            <!-- First_name Form input -->
            {{ Form::label('first_name', 'First Name:') }}
            {{ Form::text('first_name', Auth::user()->first_name) }}

            <!-- Last_name Form input -->
            {{ Form::label('last_name', 'Last Name:') }}
            {{ Form::text('last_name', Auth::user()->last_name) }}

            <!-- Dob Form input -->
            {{ Form::label('date_of_birth', 'Date Of Birth:') }}
            {{ Form::text('date_of_birth', Auth::user()->date_of_birth, ['placeholder' => 'dd/mm/YYYY']) }}

            {{ Form::label('country', 'Country') }}
            {{ Form::select('country', Lang::get('countries'), Auth::user()->country) }}

            {{ Form::label('gender', 'Gender') }}
            {{ Form::select('gender', ['F' => 'Female', 'M' => 'Male'], Auth::user()->gender) }}

            {{ Form::label('about', 'About You:') }}
            {{ Form::textarea('about', Auth::user()->about, ['rows' => 3]) }}

            <!-- Submit button -->
            {{ Form::submit('Save Profile', ['class' => 'button']) }}

            {{ Form::close() }}
        </div>
    </div>
@stop