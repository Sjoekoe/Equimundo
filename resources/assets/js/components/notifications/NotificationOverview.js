var Vue = require('vue');

module.exports = Vue.extend({
    template: '#notifications-template',

    props: ['notifications'],

    data: function() {
        return {
            notifications: [],
            fetching: false,
            marking: false,
            page: 1,
        };
    },

    ready: function() {
        $.getJSON('/api/notifications', function(notifications) {
            this.notifications = notifications.data;
        }.bind(this));
    },

    methods: {
        deleteNotification: function(notification) {
            this.notifications.$remove(notification);
            $.ajax({
                url: '/api/notifications/' + notification.id,
                type: 'post',
                data: {_method: 'delete'},
            });
        },

        markAllAsRead: function() {
            this.marking = true;

            $.getJSON('/api/notifications/mark-as-read', function(notifications) {
                this.notifications = notifications.data;
                this.marking = false;
            }.bind(this));
        },

        fetchMore: function() {
            this.fetching = true;
            this.page += 1;
            var vm = this;

            $.getJSON('/api/notifications?page=' + this.page, function(notifications) {
                notifications.data.map(function(notification) {
                    vm.notifications.push(notification);
                });

                vm.fetching = false;
            }.bind(vm));
        }
    }
});
