@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="row">
        <div class="col s12">
            {{ Form::open(['route' => ['palmares.store', $horse->slug], 'class' => 'grid-content medium-12']) }}
                <div class="row">
                    <div class="col s6 input-field">
                        {{ Form::label('event_name', 'Venue') }}
                        {{ Form::text('event_name') }}
                    </div>
                    <div class="col s6 input-field">
                        {{ Form::label('date', 'Date') }}
                        {{ Form::text('date', null, ['placeholder' => 'dd/mm/YYYY']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col s6 input-field">
                        {{ Form::select('discipline', trans('disciplines.list'), null, ['class' => 'discipline-select']) }}
                        {{ Form::label('discipline', 'Discipline') }}
                    </div>
                    <div class="col s6 input-field">
                        {{ Form::label('level', 'category') }}
                        {{ Form::text('level') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col s6 input-field">
                        {{ Form::label('ranking', 'ranking') }}
                        {{ Form::text('ranking') }}
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 input-field">
                        {{ Form::label('body', 'Your story') }}
                        {{ Form::textarea('body', null, ['class' => 'materialize-textarea']) }}
                    </div>
                </div>
                {{ Form::submit('save achievement', ['class' => 'btn']) }}
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