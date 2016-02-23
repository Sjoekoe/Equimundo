@extends('layout.app')

@section('content')
    <div id="page-content">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <div class="btn-group">
                            <a href="{{ route('notifications.mark-read') }}" class="btn btn-info pull-right">
                                {{ trans('copy.a.mark_as_read') }}
                            </a>
                        </div>
                    </div>
                    <h3 class="panel-title">
                        Notifications
                    </h3>
                </div>
                <div class="panel-body">
                    @if (count($notifications))
                        <ul class="list-group list-group-striped">
                            @foreach ($notifications as $notification)
                                <li class="list-group-item list-item-lg {{ $notification->isUnread() ? 'text-bold text-warning' : '' }}">
                                    <a href="{{ route('notifications.show', $notification->id()) }}">
                                        {{ trans('notifications.' . $notification->type(), json_decode($notification->data(), true)) }}
                                    </a>
                                    <a href="{{ route('notification.delete', $notification->id()) }}" class="pull-right color-mint">
                                        <i class="fa fa-trash fa-lg text-mint"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>{{ trans('copy.p.no_notifications') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
