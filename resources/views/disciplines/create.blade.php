@extends('layout.app')

@section('content')
    @include('layout.partials.errors')
    <div class="row">
        <div class="row">
            <div class="col s6">
                <h3>{{ trans('copy.titles.disciplines') }}</h3>
            </div>
        </div>
        {{ Form::open(['route' => ['disciplines.store', $horse->slug()], 'class' => 'form-horizontal col s12', 'files' => 'true']) }}
            <div class="row">
            <fieldset>
                <legend>Various</legend>
                @foreach (trans('disciplines.various') as $key => $value)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $key, $horse->performsDiscipline($key), ['id' => $key]) }}
                        {{ Form::label($key, $value) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Racing</legend>
                @foreach (trans('disciplines.racing') as $key => $value)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $key, $horse->performsDiscipline($key), ['id' => $key]) }}
                        {{ Form::label($key, $value) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Classic</legend>
                @foreach (trans('disciplines.classic') as $key => $value)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $key, $horse->performsDiscipline($key), ['id' => $key]) }}
                        {{ Form::label($key, $value) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Western</legend>
                @foreach (trans('disciplines.western') as $key => $value)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $key, $horse->performsDiscipline($key), ['id' => $key]) }}
                        {{ Form::label($key, $value) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Harness</legend>
                @foreach (trans('disciplines.harness') as $key => $value)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $key, $horse->performsDiscipline($key), ['id' => $key]) }}
                        {{ Form::label($key, $value) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Team sports</legend>
                @foreach (trans('disciplines.team') as $key => $value)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $key, $horse->performsDiscipline($key), ['id' => $key]) }}
                        {{ Form::label($key, $value) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Ancient</legend>
                @foreach (trans('disciplines.ancient') as $key => $value)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $key, $horse->performsDiscipline($key), ['id' => $key]) }}
                        {{ Form::label($key, $value) }}
                    </div>
                @endforeach
            </fieldset>
        </div>
        {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn']) }}
        {{ Form::close() }}
    </div>
@stop
