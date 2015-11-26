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
                @foreach (\EQM\Models\Disciplines\Discipline::VARIOUS as $discipline)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                        {{ Form::label($discipline, trans('disciplines.' . $discipline)) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Racing</legend>
                @foreach (\EQM\Models\Disciplines\Discipline::RACING as $discipline)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                        {{ Form::label($discipline, trans('disciplines.' . $discipline)) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Classic</legend>
                @foreach (\EQM\Models\Disciplines\Discipline::CLASSIC as $discipline)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                        {{ Form::label($discipline, trans('disciplines.' . $discipline)) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Western</legend>
                @foreach (\EQM\Models\Disciplines\Discipline::WESTERN_SPORTS as $discipline)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                        {{ Form::label($discipline, trans('disciplines.' . $discipline)) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Harness</legend>
                @foreach (\EQM\Models\Disciplines\Discipline::HARNESS as $discipline)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                        {{ Form::label($discipline, trans('disciplines.' . $discipline)) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Team sports</legend>
                @foreach (\EQM\Models\Disciplines\Discipline::TEAM as $discipline)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                        {{ Form::label($discipline, trans('disciplines.' . $discipline)) }}
                    </div>
                @endforeach
            </fieldset>
            <br>
            <fieldset>
                <legend>Ancient</legend>
                @foreach (\EQM\Models\Disciplines\Discipline::ANCIENT as $discipline)
                    <div class="input-field col s3">
                        {{ Form::checkbox('disciplines[]', $discipline, $horse->performsDiscipline($discipline), ['id' => $discipline]) }}
                        {{ Form::label($discipline, trans('disciplines.' . $discipline)) }}
                    </div>
                @endforeach
            </fieldset>
        </div>
        {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn']) }}
        {{ Form::close() }}
    </div>
@stop
