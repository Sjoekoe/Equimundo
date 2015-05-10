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

        <div class="grid-block medium-12">
            @if (count($horse->pictures))
                @foreach ($horse->pictures as $picture)
                    @include('horses.pictures._partials.picture-block')
                @endforeach
            @endif
        </div>
    </div>
@stop