var Vue = require('vue');

var Notification = Vue.extend({
    template: '#notifications-template',

    props: ['notifications'],

    data: function() {
        return {
            notifications: []
        };
    },

    ready: function() {
        $.getJSON('api/notifications', function(notifications) {
            this.notifications = notifications.data;
        }.bind(this));
    },

    methods: {
        deleteNotification: function(notification) {
            this.notifications.$remove(notification);
            $.ajax({
                url: 'api/notifications/' + notification.id,
                type: 'post',
                data: {_method: 'delete'}
            });
        },

        markAllAsRead: function() {
            $.getJSON('api/notifications/mark-as-read', function(notifications) {
                this.notifications = notifications.data;
            }.bind(this));
        }
    }
});

Vue.component('notifications', Notification);

new Vue({
    el: 'body'
});
