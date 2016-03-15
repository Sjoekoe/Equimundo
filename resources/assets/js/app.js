var Vue = require('vue');

new Vue({
    el: 'body',

    components: {
        notifications: require('./components/notifications'),
        horsefeed: require('./components/statuses/horseFeed'),
        userfeed: require('./components/statuses/userFeed')
    }
});
