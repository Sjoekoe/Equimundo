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
                    <a href="{{ route('horses.edit', $horse->id) }}" class="button">Edit {{ $horse->name }}</a>
                @endif
            </div>
        </div>

        @if (! count($horse->statuses))
            <p>There are no statuses yet</p>
        @else
            @foreach($horse->statuses as $status)
                @include('statuses.partials.status')
            @endforeach
        @endif
    </div>
@stop