<template id="notedrop">
    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle" @click="resetNotificationCount()">
            <i class="fa fa-bell fa-lg"></i>
            <span class="badge badge-header badge-danger" v-if="unread_notifications">@{{ unread_notifications }}</span>
        </a>

        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow">
            <div class="nano scrollable">
                <div class="nano-content">
                    <ul class="head-list">
                        <li v-for="notification in notifications" v-bind:class="{ 'bg-warning': ! notification.is_read }">
                            <a v-bind:href="notification.url" class="media">
                                <div class="media-left">
                                        <span class="icon-wrap icon-circle bg-primary">
                                            <i class="fa @{{ notification.icon }} fa-lg"></i>
                                        </span>
                                </div>
                                <div class="media-body">
                                    <div>@{{ notification.message }}</div>
                                    <small class="text-muted">@{{ notification.created_at | timeformat }}</small>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!--Dropdown footer-->
            <div class="pad-all bord-top">
                <a href="{{ route('notifications.index') }}" class="btn-link text-dark box-block">
                    <i class="fa fa-angle-right fa-lg pull-right"></i>{{ trans('copy.a.show_all_notifications') }}
                </a>
            </div>
        </div>
    </li>
</template>
