@extends('layout.app')

@section('content')
    <div class="grid-block medium-12">
        <h2>{{ trans('copy.titles.messages') }}</h2>
        @if (count(auth()->user()->conversations()))
            <ul>
                @foreach (auth()->user()->conversations() as $conversation)
                    @if (! $conversation->isDeletedForUser(auth()->user()))
                        <li>
                            <a href="{{ route('conversation.delete', $conversation->id()) }}">[X]</a>
                            <a href="{{ route('conversation.show', $conversation->id()) }}">
                                {{ $conversation->subject() }} ({{ $conversation->contactPerson(auth()->user())->fullName() }})
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @else
            {{ trans('copy.p.no_conversations') }}
        @endif
    </div>
@stop
