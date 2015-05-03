@extends('layout.app')

@section('content')
    <h3>Edit {{ $horse->name }}</h3>
    {{ Form::open() }}
        @include('layout.partials.errors')

        {{ Form::open(['route' => 'horses.update', 'method' => 'put']) }}
        <!-- Name Form input -->
        <div class="form-group">
            {{ Form::label('name', 'Name:', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::text('name', $horse->name, ['class' => 'form-control']) }}
            </div>
        </div>

        <!-- Gender Form Input -->
        <div class="form-group">
            {{ Form::label('gender', 'Gender:', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::select('gender', Lang::get('horses.genders'), $horse->gender, ['class' => 'form-control']) }}
            </div>
        </div>

        <!-- Breed Form input -->
        <div class="form-group">
            {{ Form::label('breed', 'Breed:', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::text('breed', $horse->breed, ['class' => 'form-control']) }}
            </div>
        </div>

        <!-- Height Form input -->
        <div class="form-group">
            {{ Form::label('height', 'Height:', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::text('height', $horse->height, ['class' => 'form-control']) }}
            </div>
        </div>

        <!-- Color Form Input -->
        <div class="form-group">
            {{ Form::label('color', 'Color:', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::select('color', Lang::get('horses.colors'), $horse->color, ['class' => 'form-control']) }}
            </div>
        </div>

        <!-- Date_of_birth Form input -->
        <div class="form-group">
            {{ Form::label('date_of_birth', 'Date Of Birth:', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::text('date_of_birth', $horse->date_of_birth, ['class' => 'form-control', 'placeholder' => 'dd/mm/yyy']) }}
            </div>
        </div>

        <!-- Life_number Form input -->
        <div class="form-group">
            {{ Form::label('life_number', 'Life Number:', ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::text('life_number', $horse->life_number, ['class' => 'form-control']) }}
            </div>
        </div>

        <!-- Submit button -->
        <div class="form-group">
            <div class="col-sm-3 col-sm-offset-2">
                {{ Form::submit('Edit ' . $horse->name, ['class' => 'button form-control']) }}
            </div>
        </div>
    {{ Form::close() }}
@stop