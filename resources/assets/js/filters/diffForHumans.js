var Vue = require('vue');
var moment = require('moment');
var nl = require('moment/locale/nl');

module.exports = Vue.filter('timeformat', function(date) {
    moment.locale('nl');
    return moment(date,'YYYY-MM-DDTHH:mm:ss.sssZ').fromNow();
});
