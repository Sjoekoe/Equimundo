@extends('layout.app')

@section('content')
    @include('layout.partials.errors')
    <div class="row">
        <div class="row">
            <div class="col s6">
                <h3>Create a Horse</h3>
            </div>
        </div>
        {{ Form::open(['route' => 'horses.create', 'class' => 'form-horizontal col s12', 'files' => 'true']) }}

            <div class="row">
                <div class="input-field col s6">
                    {{ Form::text('name', null) }}
                    {{ Form::label('name', 'Name:') }}
                </div>
                <div class="input-field col s6">
                    {{ Form::label('date_of_birth', 'Date Of Birth:') }}
                    {{ Form::text('date_of_birth', null, ['placeholder' => 'dd/mm/yyyy']) }}
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
                    {{ Form::text('height', null) }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    {{ Form::select('gender', trans('horses.genders'), null, ['class' => 'gender-select']) }}
                    {{ Form::label('gender', 'Gender:') }}
                </div>
                <div class="input-field col s6">
                    {{ Form::select('breed', trans('horses.breeds'), null, ['class' => 'breed-select']) }}
                    {{ Form::label('breed', 'Breed:') }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    {{ Form::select('color', trans('horses.colors'), null, ['class' => 'color-select']) }}
                    {{ Form::label('color', 'Color:') }}
                </div>
                <div class="input-field col s6">
                    {{ Form::label('life_number', 'Life Number:') }}
                    {{ Form::text('life_number', null) }}
                </div>
            </div>
            <div class="row">
                @foreach ($disciplines as $key => $value)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $key, null, ['id' => $key]) }}
                        {{ Form::label($key, $value) }}
                    </div>
                @endforeach
            </div>
            {{ Form::submit('Create Horse', ['class' => 'btn']) }}
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
