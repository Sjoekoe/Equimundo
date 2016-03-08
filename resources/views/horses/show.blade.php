@extends('layout.app')

@section('content')
    <div class="page-content">
        @include('layout.partials.heading')

        <div class="col-lg-7 col-lg-offset-2">
            @if (! count($statuses))
                <div class="panel">
                    <div class="panel-body">
                        <p class="text-center">{{ trans('copy.p.no_statuses') }}</p>
                    </div>
                </div>
            @else
                <div class="status-scroll">
                    @foreach($statuses as $status)
                        @include('statuses.partials.status')
                    @endforeach
                    {{ $statuses->render() }}
                </div>
            @endif
        </div>
    </div>
@stop
