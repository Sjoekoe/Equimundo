var Vue = require('vue');

module.exports = Vue.extend({
    template: '#rectangle-template',

    props: ['rectangle'],

    data: function() {
        return {
            found: false,
            advertisement: '',
        }
    },

    ready: function() {
        $.getJSON('/api/admin/advertisements/random?type=rectangle', function(advertisement) {
            if (advertisement !== undefined) {
                this.advertisement = advertisement.data;
                this.found = true;
                this.addView();
            }
        }.bind(this));
    },

    methods: {
        addView: function() {
            var data = {
                "view": true,
            }

            $.ajax({
                url: '/api/admin/advertisements/' + this.advertisement.id,
                type: 'put',
                data: data,
            })
        },

        addClick: function(advertisement) {
            var data = {
                "click": true,
            }

            $.ajax({
                url: '/api/admin/advertisements/' + advertisement.id,
                type: 'put',
                data: data,
            })
        }
    }
});
