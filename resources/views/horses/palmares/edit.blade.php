@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col s12">
            {{ Form::open(['route' => ['palmares.update', $palmares->id], 'class' => 'grid-content medium-12']) }}
            <div class="row">
                <div class="col s6 input-field">
                    {{ Form::label('event_name', 'Venue') }}
                    {{ Form::text('event_name', $palmares->event->name) }}
                </div>
                <div class="col s6 input-field">
                    {{ Form::label('date', 'Date') }}
                    {{ Form::text('date', date('d/m/Y', strtotime($palmares->date)), ['placeholder' => 'dd/mm/YYYY']) }}
                </div>
            </div>
            <div class="row">
                <div class="col s6 input-field">
                    {{ Form::select('discipline', trans('disciplines.list'), $palmares->discipline, ['class' => 'discipline-select']) }}
                    {{ Form::label('discipline', 'Discipline') }}
                </div>
                <div class="col s6 input-field">
                    {{ Form::label('level', 'category') }}
                    {{ Form::text('level', $palmares->level) }}
                </div>
            </div>
            <div class="row">
                <div class="col s6 input-field">
                    {{ Form::label('ranking', 'ranking') }}
                    {{ Form::text('ranking', $palmares->ranking) }}
                </div>
            </div>
            <div class="row">
                <div class="col s12 input-field">
                    {{ Form::label('body', 'Your story') }}
                    {{ Form::textarea('body', $palmares->status->body, ['class' => 'materialize-textarea']) }}
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
