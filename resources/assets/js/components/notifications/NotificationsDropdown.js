var Vue = require('vue');
var Pusher = require('pusher-js');

module.exports = Vue.extend({
    template: '#notedrop',

    props: ['notedrop'],

    data: function() {
        return {
            unread_notifications: 0,
            user_email: '',
            notifications: [],
            user: {},
        };
    },

    ready: function() {
        $.getJSON('/api/users/' + window.user_id, function (user) {
            this.user = user;
            this.unread_notifications = user.data.unread_notifications;
            this.user_email = user.data.email;
        }.bind(this));

        $.getJSON('/api/notifications', function(notifications) {
            this.notifications = notifications.data;
        }.bind(this));

        this.pusher = new Pusher('50125ce9622090efbd5a');
        this.pusherChannel = this.pusher.subscribe('user-' + window.user_id + '');

        this.pusherChannel.bind('EQM\\Events\\NotificationWasSent', function(data) {
            this.unread_notifications += 1;
            this.notifications.unshift(data.notification);
        }.bind(this));
    },

    methods: {
        markAllAsRead: function() {
            $.getJSON('/api/notifications/mark-as-read', function(notifications) {
                this.notifications = notifications.data;
            }.bind(this));
        },

        resetNotificationCount: function() {
            if (this.unread_notifications) {
                $.getJSON('/api/users/' + this.user.data.id + '/notifications/reset-count', function() {
                    this.unread_notifications = 0;
                }.bind(this));
            }
        }
    }
});
