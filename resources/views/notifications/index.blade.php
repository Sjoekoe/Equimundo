@extends('layout.app')

@section('content')
    <div class="row">
        <a href="{{ route('notifications.mark-read') }}">{{ trans('copy.a.mark_as_read') }}</a>
        <ul>
            @foreach ($notifications as $notification)
                <li>
                    <a href="{{ route('notifications.show', $notification->id()) }}">
                        {{ trans('notifications.' . $notification->type(), json_decode($notification->data(), true)) }}
                    </a>
                    <a href="{{ route('notification.delete', $notification->id()) }}">
                        [x]
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@stop
