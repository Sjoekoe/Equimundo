@extends('layout.app')

@section('content')
    @include('layout.partials.heading')
        <div class="grid-block medium-12">
            @if (count($horse->pictures))
                @foreach ($horse->pictures as $picture)
                    @include('horses.pictures._partials.picture-block')
                @endforeach
            @endif
        </div>
    </div>
@stop