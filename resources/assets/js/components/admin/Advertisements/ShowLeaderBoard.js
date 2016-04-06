var Vue = require('vue');

module.exports = Vue.extend({
    template: '#leaderboard-template',

    props: ['leaderboard'],

    data: function() {
        return {
            found: false,
            advertisement: '',
        }
    },

    ready: function() {
        $.getJSON('/api/admin/advertisements/random?type=leaderboard', function(advertisement) {
            this.advertisement = advertisement.data;
            this.found = true;
            this.addView();
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
                url: '/api/admin/advertisements/' + this.advertisement.id,
                type: 'put',
                data: data,
            })
        }
    }
});
