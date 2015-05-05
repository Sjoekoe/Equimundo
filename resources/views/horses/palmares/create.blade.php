@extends('layout.app')

@section('content')
    <div class="grid-content">
        <div class="grid-block medium-12 clearfix heading">
            <div class="pull-left">
                <h1>{{ $horse->name }}</h1>
            </div>

            <div class="pull-right">
                @if ($horse->owner()->first()->id !== Auth::user()->id)
                    @include('horses.partials.follow-form')
                @endif
            </div>
        </div>

        @include('horses.partials.menu-bar')
        
        <div class="grid-block medium-12">
            {{ Form::open(['route' => ['palmares.store', $horse->slug], 'class' => 'grid-content medium-12']) }}
                {{ Form::label('event_name', 'Venue') }}
                {{ Form::text('event_name') }}
                {{ Form::label('date', 'Date') }}
                {{ Form::text('date') }}
                {{ Form::label('discipline', 'Discipline') }}
                {{ Form::select('discipline', trans('disciplines.list'), null) }}
                {{ Form::label('level', 'category') }}
                {{ Form::text('level') }}
                {{ Form::label('ranking', 'ranking') }}
                {{ Form::text('ranking') }}
                {{ Form::label('body', 'Your story') }}
                {{ Form::textarea('body') }}
                {{ Form::submit('save achievement', ['class' => 'button']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop