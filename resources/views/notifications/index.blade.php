@extends('layout.app')

@section('content')
    <div id="page-content">
        <div class="col-md-4 col-md-offset-4">
            <notifications></notifications>

            <template id="notifications-template">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-control">
                            <div class="btn-group">
                                <button class="btn btn-info pull-right" @click="markAllAsRead">
                                    {{ trans('copy.a.mark_as_read') }}
                                </button>
                            </div>
                        </div>
                        <h3 class="panel-title">
                            Notifications
                        </h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group list-group-striped">
                            <li class="list-group-item list-item-lg " v-for="notification in notifications" v-bind:class="{ 'text-bold': ! notification.is_read }">
                                <a href="@{{ notification.url }}">
                                    @{{ notification.message }}
                                </a>
                                <i class="fa fa-trash fa-lg text-mint pull-right" @click="deleteNotification(notification)"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </template>
        </div>
    </div>
@stop
