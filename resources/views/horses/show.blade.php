@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="row">
        @if (! count($horse->statuses))
            <p>There are no statuses yet</p>
        @else
            @foreach($horse->statuses as $status)
                @include('statuses.partials.status')
            @endforeach
        @endif
    </div>
@stop