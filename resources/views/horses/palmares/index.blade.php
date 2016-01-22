@extends('layout.app')

@section('content')
    <div class="page-content">
        @include('layout.partials.heading')
        @if (auth()->user()->isInHorseTeam($horse))
            <div class="row">
                <a href="{{ route('palmares.create', $horse->slug) }}" class="btn">{{ trans('copy.a.add_achievement') }}</a>
            </div>
        @endif
        <div class="col-lg-7 col-lg-offset-2">
            @if (! count($horse->palmares))
                <p>{{ $horse->name }} {{ trans('copy.p.no_palmares') }}</p>
            @else
                @foreach ($palmaresResults as $palmares)
                    @include('horses.palmares._partials.palmares')
                @endforeach
            @endif
        </div>
    </div>

@stop
