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
                    <a href="{{ route('palmares.create', $horse->slug) }}" class="button">Add Achievement</a>
                @endif
            </div>
        </div>

        @include('horses.partials.menu-bar')

        @if (! count($horse->palmares))
            <p>{{ $horse->name }} has no palmares yet.</p>
        @else
            @foreach ($horse->palmares as $palmares)
                {{ array_flatten(trans('disciplines.list'))[$palmares->discipline - 1] }}
                @if ($palmares->event)
                    {{ $palmares->event->name }}
                @endif
            @endforeach
        @endif
    </div>
@stop