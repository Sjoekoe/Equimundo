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

        this.pusherChannel.bind('EQM\\Events\\NotificationWasSent', function(response) {
            this.unread_notifications += 1;
            $.getJSON('/api/notifications/' + response.notification.id, function(notification) {
                this.notifications.unshift(notification.data);
                $.niftyNoty({
                    container:'floating',
                    timer : 3000,
                    html: '<div class="media-left"><span class="icon-wrap icon-wrap-xs icon-circle alert-icon"><i class="fa ' + notification.data.icon +' fa-lg"></i></span></div><div class="media-body"><p class="alert-message">' + notification.data.message + '</p></div>'
                });
            }.bind(this));
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
