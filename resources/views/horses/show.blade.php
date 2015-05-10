@extends('layout.app')

@section('content')
    <div class="grid-content">
        <div class="grid-block medium-12 clearfix heading">
            <div class="heading-name">
                <h1>{{ $horse->name }}</h1>
            </div>

            <div class="heading-button">
                @if ($horse->owner()->first()->id !== Auth::user()->id)
                    @include('horses.partials.follow-form')
                @else
                    <a href="{{ route('horses.edit', $horse->id) }}" class="button">Edit {{ $horse->name }}</a>
                @endif
            </div>
        </div>

        @include('horses.partials.menu-bar')

        @if (! count($horse->statuses))
            <p>There are no statuses yet</p>
        @else
            @foreach($horse->statuses as $status)
                @include('statuses.partials.status')
            @endforeach
        @endif
    </div>
@stop