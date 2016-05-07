<template id="notedrop">
    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle counnt-info" @click="resetNotificationCount()">
            <i class="fa fa-bell"></i>
            <span class="label label-primary" v-if="unread_notifications">@{{ unread_notifications }}</span>
        </a>

        <ul class="dropdown-menu ">
            <template v-for="notification in notifications">
                <li v-bind:class="{ 'bg-warning': ! notification.is_read }">
                    <a v-bind:href="notification.url">
                        <i class="fa @{{ notification.icon }}"></i> @{{ notification.message }} <br>
                        <span class="pull-left text-muted small">@{{ notification.created_at | diffForHumans }}</span>
                    </a>
                </li>
                <br>
                <li class="divider"></li>
            </template>
            <li>
                <div class="text-center link-block">
                    <a href="{{ route('notifications.index') }}">
                        <strong>{{ trans('copy.a.show_all_notifications') }}</strong>
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </li>
        </ul>
    </li>
</template>
