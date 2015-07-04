@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    @if (Auth::user()->isHorseOwner($horse))
        <div class="row">
            <a href="{{ route('palmares.create', $horse->slug) }}" class="btn">{{ trans('copy.a.add_achievement') }}</a>
        </div>
    @endif
    <div class="row">
        @if (! count($horse->palmares))
            <p>{{ $horse->name }} {{ trans('copy.p.no_palmares') }}</p>
        @else
            @foreach ($palmaresResults as $palmares)
                @include('horses.palmares._partials.palmares')
            @endforeach
        @endif
    </div>
@stop
