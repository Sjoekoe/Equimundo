@extends('layout.app')

@section('content')
    <div class="grid-content">
        <div class="grid-block medium-12 clearfix heading">
            <div class="pull-left">
                <h1>Followers for {{ $horse->name }}</h1>
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


            @foreach ($horse->followers as $follower)
                {{ $follower->username }}
            @endforeach

    </div>
@stop