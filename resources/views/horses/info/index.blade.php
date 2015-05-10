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
                    <a href="{{ route('horses.edit', $horse->slug) }}" class="button">Edit Horse</a>
                @endif
            </div>
        </div>

        @include('horses.partials.menu-bar')

        <div class="grid-block medium-12">
            <ul>
                <li>{{ $horse->name }}</li>
                <li>{{ array_flatten(trans('horses.breeds'))[$horse->breed -1] }}</li>
                <li>{{ trans('horses.genders')[$horse->gender] }}</li>
                <li>{{ $horse->date_of_birth }}</li>
                <li>{{ $horse->height }}</li>
                <li>{{ trans('horses.colors')[$horse->color] }}</li>
            </ul>
        </div>
    </div>
@stop