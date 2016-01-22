@extends('layout.app')

@section('content')
    <div class="page-content">
        @include('layout.partials.heading')

        <div class="col-lg-7 col-lg-offset-2">
            @if (! count($horse->statuses()))
                <p>{{ trans('copy.p.no_statuses') }}</p>
            @else
                @foreach($horse->statuses() as $status)
                    @include('statuses.partials.status')
                @endforeach
            @endif
        </div>
    </div>
@stop
