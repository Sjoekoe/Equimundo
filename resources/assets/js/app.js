var Vue = require('vue');

new Vue({
    el: 'body',

    filters: {
        diffForHumans: require('./filters/diffForHumans'),
        timeFormat: require('./filters/timeFormat'),
    },

    components: {
        showconversation: require('./components/conversations/ShowConversation'),

        advertisementstable: require('./components/admin/Advertisements/AdvertisementsTable'),
        advertisingcompany: require('./components/admin/Advertisements/ShowAdvertisingCompany'),
        advertisingcompaniestable: require('./components/admin/Advertisements/AdvertisingCompaniesTable'),
        createadvertisement: require('./components/admin/Advertisements/CreateAdvertisement'),
        createadvertisingcompany: require('./components/admin/Advertisements/CreateAdvertisingCompany'),
        leaderboard: require('./components/admin/Advertisements/ShowLeaderBoard'),
        rectangle: require('./components/admin/Advertisements/ShowRectangle'),
        showadvertisement: require('./components/admin/Advertisements/ShowAdvertisement'),

        showcompany: require('./components/companies/ShowCompany'),
        createcompany: require('./components/companies/CreateCompany'),
        editcompany: require('./components/companies/EditCompany'),

        admindash: require('./components/admin/dashboard'),
        notedrop: require('./components/notifications/NotificationsDropdown'),
        notifications: require('./components/notifications/NotificationOverview'),
        searchbar: require('./components/search/SearchBar'),
        horsefeed: require('./components/statuses/horseFeed'),
        horsestatus: require('./components/statuses/horseDetailStatus'),
        userfeed: require('./components/statuses/userFeed'),
        singlestatus: require('./components/statuses/singleStatus'),
        statuscreator: require('./components/statuses/statusCreator'),

        sidebarbutton: require('./components/nav/CollapseSideBar'),

        followhorse: require('./components/horses/FollowHorse'),

        wikitopicstable: require('./components/wiki/TopicsTable'),
    },
});
