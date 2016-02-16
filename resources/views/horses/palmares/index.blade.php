@extends('layout.app')

@section('content')
    <div class="page-content">
        @include('layout.partials.heading')
        <div class="col-lg-7 col-lg-offset-2">
            @if (auth()->user()->isInHorseTeam($horse))
                <div class="row">
                    <div class="col-sx-3 pull-right">
                        <a href="{{ route('palmares.create', $horse->slug) }}" class="btn btn-info">{{ trans('copy.a.add_achievement') }}</a>
                    </div>
                </div>
                <br>
            @endif
            @if (! count($horse->palmares))
                <div class="panel">
                    <div class="panel-body">
                        <p class="text-center">{{ $horse->name }} {{ trans('copy.p.no_palmares') }}</p>
                    </div>
                </div>
            @else
                @foreach ($palmaresResults as $palmares)
                    @include('horses.palmares._partials.palmares')
                @endforeach
            @endif
        </div>
    </div>
@stop
