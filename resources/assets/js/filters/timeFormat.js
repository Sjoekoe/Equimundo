var Vue = require('vue');
var moment = require('moment-timezone');

module.exports = Vue.filter('timeFormat', function(date) {
    return moment(date,'YYYY-MM-DDTHH:mm:ss.sssZ').format('DD-MM-Y');
});
