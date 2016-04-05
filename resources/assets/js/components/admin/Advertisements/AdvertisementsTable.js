var Vue = require('vue');

module.exports = Vue.extend({
    template: '#advertisements-table',

    props: ['advertisementstable'],

    data: function() {
        return {
            advertisements: [],
        }
    },

    ready: function() {
        $.getJSON('/api/admin/advertisements', function(advertisements) {
            this.advertisements = advertisements.data;
        }.bind(this));
    },

    methods: {
        delete: function(advertisement) {
            this.advertisements.$remove(advertisement);
            $.ajax({
                url: '/api/admin/advertisements/' + advertisement.id,
                type: 'post',
                data: {_method: 'delete'},
            });
        }
    }
});
