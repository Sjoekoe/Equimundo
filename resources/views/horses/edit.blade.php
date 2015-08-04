@extends('layout.app')

@section('content')
    <div class="row">
        <div class="row">
            <div class="col s6">
                <h3>{{ trans('copy.titles.edit') }} {{ $horse->name }}</h3>
            </div>
        </div>
        {{ Form::open(['route' => ['horses.edit', $horse->slug], 'class' => 'col s12', 'files' => 'true', 'method' => 'put']) }}

            <div class="row">
                <div class="input-field col s6">
                    {{ Form::text('name', $horse->name) }}
                    {{ Form::label('name', trans('forms.labels.name')) }}
                </div>
                <div class="input-field col s6">
                    {{ Form::label('date_of_birth', trans('forms.labels.date_of_birth')) }}
                    {{ Form::text('date_of_birth', $horse->getBirthDay(), ['placeholder' => 'dd/mm/yyyy']) }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    {{ Form::label('height', trans('forms.labels.height')) }}
                    {{ Form::text('height', $horse->height) }}
                </div>
                <div class="input-field col s6">
                    {{ Form::select('gender', trans('horses.genders'), $horse->gender, ['class' => 'gender-select']) }}
                    {{ Form::label('gender', trans('forms.labels.gender')) }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    {{ Form::select('breed', trans('horses.breeds'), $horse->breed, ['class' => 'breed-select']) }}
                    {{ Form::label('breed', trans('forms.labels.breed')) }}
                </div>
                <div class="input-field col s6">
                    {{ Form::select('color', trans('horses.colors'), $horse->color, ['class' => 'color-select']) }}
                    {{ Form::label('color', trans('forms.labels.color')) }}
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    {{ Form::label('life_number', trans('forms.labels.life_number')) }}
                    {{ Form::text('life_number', $horse->life_number) }}
                </div>
            </div>
            <div class="row">
                @foreach ($disciplines as $key => $value)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $key, $horse->performsDiscipline($key), ['id' => $key]) }}
                        {{ Form::label($key, $value) }}
                    </div>
                @endforeach
            </div>
            <br/>
            {{ Form::submit(trans('forms.labels.save'), ['class' => 'btn']) }}
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
