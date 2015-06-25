@extends('layout.app')

@section('content')
    <div class="grid-block medium-12">
        <h2>Messages</h2>
        @if (count($conversations))
            <ul>
                @foreach ($conversations as $conversation)
                    <li>
                        <a href="{{ route('conversation.delete', $conversation->id) }}">[X]</a>
                        <a href="{{ route('conversation.show', $conversation->id) }}">
                            {{ $conversation->subject }} ({{ $conversation->contactPerson(Auth::user())->username }})
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            You have no conversations yet
        @endif
    </div>
@stop
