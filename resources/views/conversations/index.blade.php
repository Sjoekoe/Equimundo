@extends('layout.app')

@section('content')
    <div class="grid-block medium-12">
        <h2>{{ trans('copy.titles.messages') }}</h2>
        @if (count($conversations))
            <ul>
                @foreach ($conversations as $conversation)
                    <li>
                        <a href="{{ route('conversation.delete', $conversation->id()) }}">[X]</a>
                        <a href="{{ route('conversation.show', $conversation->id()) }}">
                            {{ $conversation->subject() }} ({{ $conversation->contactPerson(Auth::user())->fullName() }})
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            {{ trans('copy.p.no_conversations') }}
        @endif
    </div>
@stop
