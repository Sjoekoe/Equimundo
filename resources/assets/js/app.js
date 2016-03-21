var Vue = require('vue');

new Vue({
    el: 'body',

    components: {
        admindash: require('./components/admin/dashboard'),
        notedrop: require('./components/notifications/NotificationsDropdown'),
        notifications: require('./components/notifications/NotificationOverview'),
        searchbar: require('./components/search/SearchBar'),
        horsefeed: require('./components/statuses/horseFeed'),
        userfeed: require('./components/statuses/userFeed')
    }
});
