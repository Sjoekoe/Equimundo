@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="row">
        @if (! count($horse->statuses))
            <p>{{ trans('copy.p.no_statuses') }}</p>
        @else
            <div class="timeline">
                <dl class="pull-left">
                    @foreach($statuses as $status)
                        @include('statuses.partials.status')
                    @endforeach
                </dl>
            </div>
        @endif
    </div>
@stop
