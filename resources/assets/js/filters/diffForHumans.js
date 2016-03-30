var Vue = require('vue');
var moment = require('moment-timezone');
var nl = require('moment/locale/nl');

module.exports = Vue.filter('timeformat', function(date) {
    moment.tz.setDefault(window.equimundo.auth ? window.equimundo.auth.user.timezone : 'UTC');
    moment.locale(window.equimundo.auth ? window.equimundo.auth.user.locale : 'en');
    return moment.tz(date,'YYYY-MM-DDTHH:mm:ss.sssZ').fromNow();
});
