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
                @else
                    <a href="{{ route('pedigree.create', $horse->slug) }}" class="button">Add Family</a>
                @endif
            </div>
        </div>

        @include('horses.partials.menu-bar')

        {{ Form::open(['route' => ['pedigree.store', $horse->slug]]) }}
            {{ Form::label('type', 'Relation') }}
            {{ Form::select('type', trans('pedigree.types')) }}
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name') }}
            {{ Form::label('life_number', 'Life Number') }}
            {{ Form::text('life_number') }}
            {{ Form::label('date_of_birth', 'Date of Birth') }}
            {{ Form::text('date_of_birth', null, ['placeholder' => 'yyyy']) }}
            {{ Form::label('date_of_death', 'Passed away:') }}
            {{ Form::text('date_of_death', null, ['placeholder' => 'yyyy']) }}
            {{ Form::submit('Save', ['class' => 'button']) }}
        {{ Form::close() }}
    </div>
@stop