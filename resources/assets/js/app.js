var Vue = require('vue');

new Vue({
    el: 'body',

    filters: {
        timeformat: require('./filters/diffForHumans'),
    },

    components: {
        advertisingcompany: require('./components/admin/Advertisements/ShowAdvertisingCompany'),
        advertisingcompaniestable: require('./components/admin/Advertisements/AdvertisingCompaniesTable'),
        createadvertisingcompany: require('./components/admin/Advertisements/CreateAdvertisingCompany'),
        admindash: require('./components/admin/dashboard'),
        notedrop: require('./components/notifications/NotificationsDropdown'),
        notifications: require('./components/notifications/NotificationOverview'),
        searchbar: require('./components/search/SearchBar'),
        horsefeed: require('./components/statuses/horseFeed'),
        horsestatus: require('./components/statuses/horseDetailStatus'),
        userfeed: require('./components/statuses/userFeed'),
        singlestatus: require('./components/statuses/singleStatus'),
        statuscreator: require('./components/statuses/statusCreator'),
    },
});
