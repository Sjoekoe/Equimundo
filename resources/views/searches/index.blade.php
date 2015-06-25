@extends('layout.app')

@section('content')
    <div class="row">
        <h3>Results</h3>
        @if (count($results))
            @foreach ($results as $result)
                <p><a href="{{ route('horses.show', $result->slug) }}">{{ $result->name }}</a></p>
            @endforeach
        @else
            <p>No results found</p>
        @endif
    </div>
@stop
