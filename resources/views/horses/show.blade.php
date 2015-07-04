@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="row">
        @if (! count($horse->statuses))
            <p>{{ trans('copy.p.no_statuses') }}</p>
        @else
            @foreach($statuses as $status)
                @include('statuses.partials.status')
            @endforeach
        @endif
    </div>
@stop
