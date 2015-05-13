@extends('layout.app')

@section('content')
    <div class="row">
        <div class="row">
            <div class="col s6">
                <h3>Edit {{ $horse->name }}</h3>
            </div>
        </div>
        {{ Form::open(['route' => ['horses.edit', $horse->id], 'class' => 'col s12', 'files' => 'true', 'method' => 'put']) }}

            <div class="row">
                <div class="input-field col s6">
                    {{ Form::text('name', $horse->name) }}
                    {{ Form::label('name', 'Name:') }}
                </div>
                <div class="input-field col s6">
                    {{ Form::label('date_of_birth', 'Date Of Birth:') }}
                    {{ Form::text('date_of_birth', $horse->getBirthDay(), ['placeholder' => 'dd/mm/yyyy']) }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 file-field">
                    <input class="file-path validate" type="text"/>
                    {{ Form::label(null, 'Profile Picture', ['style' => 'left:115px;']) }}
                    <div class="btn waves-effect waves-light">
                        <span>File</span>
                        {{ Form::file('profile_pic') }}
                    </div>
                </div>
                <div class="input-field col s6">
                    {{ Form::label('height', 'Height:') }}
                    {{ Form::text('height', $horse->height) }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    {{ Form::select('gender', Lang::get('horses.genders'), $horse->gender, ['class' => 'gender-select']) }}
                    {{ Form::label('gender', 'Gender:') }}
                </div>
                <div class="input-field col s6">
                    {{ Form::select('breed', trans('horses.breeds'), $horse->breed, ['class' => 'breed-select']) }}
                    {{ Form::label('breed', 'Breed:') }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    {{ Form::select('color', Lang::get('horses.colors'), $horse->color, ['class' => 'color-select']) }}
                    {{ Form::label('color', 'Color:') }}
                </div>
                <div class="input-field col s6">
                    {{ Form::label('life_number', 'Life Number:') }}
                    {{ Form::text('life_number', $horse->life_number) }}
                </div>
            </div>
            {{ Form::submit('Edit ' . $horse->name, ['class' => 'btn']) }}
        {{ Form::close() }}
    </div>
@stop

@section('footer')
    <script>
        $(document).ready(function() {
            $('.gender-select').material_select();
            $('.breed-select').material_select();
            $('.color-select').material_select();
        });
    </script>
@stop