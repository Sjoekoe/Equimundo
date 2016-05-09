@extends('layout.app', ['title' => trans('copy.titles.notifications'), 'pageTitle' => true])

@section('content')
    @include('advertisements.leaderboard')

    <div class="row">
        <div class="col-md-12">
            <notifications></notifications>

            <template id="notifications-template">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <button class="btn btn-info btn-xs" disabled v-if="marking">
                                <i class="fa fa-spinner fa-spin"></i>
                            </button>
                            <button class="btn btn-info btn-xs" v-else @click="markAllAsRead">
                                {{ trans('copy.a.mark_as_read') }}
                            </button>
                            <button class="btn btn-info btn-xs" disabled v-if="fetching">
                                <i class="fa fa-spinner fa-spin"></i>
                            </button>
                            <button class="btn btn-info btn-xs" v-else @click="fetchMore">
                                {{ trans('copy.a.show_more') }}
                            </button>
                        </div>
                    </div>
                    <div class="ibox-content no-padding">
                        <ul class="list-group">
                            <li class="list-group-item " v-for="notification in notifications" >
                                <i class="fa fa-eye text-danger" v-if="! notification.is_read"></i>
                                <i class="fa fa-check text-info" v-else></i>
                                <a href="@{{ notification.url }}" v-bind:class="{ 'text-danger': ! notification.is_read }">
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
