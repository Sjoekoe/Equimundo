var Vue = require('vue');

module.exports = Vue.extend({
    template: '#show-advertisement',

    props: ['showadvertisement'],

    data: function() {
        return {
            advertisement: '',
            contact: '',
            fetching: true,
        }
    },

    ready: function() {
        $.getJSON('/api/admin/advertisements/' + window.equimundo.advertisement.id, function(advertisement) {
            this.advertisement = advertisement.data;
            this.contact = advertisement.data.companyRelation.data.contactRelation.data;
            this.fetching = false;
        }.bind(this));
    },
});
