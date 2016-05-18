var Vue = require('vue');
var Pusher = require('pusher-js');
var toastr = require('toastr');
var userId = window.equimundo.auth ? window.equimundo.auth.user.id : null;

module.exports = Vue.extend({
    template: '#notedrop',

    props: ['notedrop'],

    data: function() {
        return {
            unread_notifications: 0,
            notifications: [],
        };
    },

    ready: function() {
        $.getJSON('/api/users/' + userId, function (user) {
            this.unread_notifications = user.data.unread_notifications;
        }.bind(this));

        $.getJSON('/api/notifications', function(notifications) {
            this.notifications = notifications.data;
        }.bind(this));

        this.pusher = new Pusher(window.equimundo.services.pusher);
        this.pusherChannel = this.pusher.subscribe('user-' + userId + '');

        this.pusherChannel.bind('EQM\\Events\\NotificationWasSent', function(response) {
            this.unread_notifications += 1;
            $.getJSON('/api/notifications/' + response.notification.id, function(notification) {
                this.notifications.unshift(notification.data);
                toastr.info(notification.data.message, '', {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": true,
                    "preventDuplicates": false,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                })
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
                $.getJSON('/api/users/' + userId + '/notifications/reset-count', function() {
                    this.unread_notifications = 0;
                }.bind(this));
            }
        }
    }
});
