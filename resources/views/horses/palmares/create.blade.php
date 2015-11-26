@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="row">
        <div class="col s12">
            {{ Form::open(['route' => ['palmares.store', $horse->slug], 'class' => 'grid-content medium-12']) }}
                <div class="row">
                    <div class="col s6 input-field">
                        {{ Form::label('event_name', trans('forms.labels.venue')) }}
                        {{ Form::text('event_name') }}
                    </div>
                    <div class="col s6 input-field">
                        {{ Form::label('date', trans('forms.labels.date')) }}
                        {{ Form::text('date', null, ['placeholder' => 'dd/mm/YYYY']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col s6 input-field">
                        {{ Form::select('discipline', trans('disciplines'), null, ['class' => 'discipline-select']) }}
                        {{ Form::label('discipline', trans('forms.labels.discipline')) }}
                    </div>
                    <div class="col s6 input-field">
                        {{ Form::label('level', trans('forms.labels.category')) }}
                        {{ Form::text('level') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col s6 input-field">
                        {{ Form::label('ranking', trans('forms.labels.ranking')) }}
                        {{ Form::text('ranking') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 input-field">
                        {{ Form::label('body', trans('forms.labels.story')) }}
                        {{ Form::textarea('body', null, ['class' => 'materialize-textarea']) }}
                    </div>
                </div>
                {{ Form::submit(trans('forms.buttons.save'), ['class' => 'btn']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('footer')
    <script>
        $(document).ready(function() {
            $('.discipline-select').material_select();
        });
    </script>
@stop
