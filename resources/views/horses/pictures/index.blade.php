@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
    <div class="row">
        @if (count($horse->pictures))
            @foreach ($horse->pictures as $picture)
                @include('horses.pictures._partials.picture-block')
            @endforeach
        @endif
    </div>
@stop
