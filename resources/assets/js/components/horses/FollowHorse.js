var Vue = require('vue');
var toastr = require('toastr');
var horseID = window.horse_id;

module.exports = Vue.extend({
    template: '#follow-form',

    props: ['followhorse'],

    data: function() {
        return {
            is_followed_by_user: false
        }
    },

    ready: function() {
        $.getJSON('/api/horses/' + horseID, function (horse) {
            this.is_followed_by_user = horse.data.is_followed_by_user;
        }.bind(this));
    },

    methods: {
        toggle: function() {
            if (this.is_followed_by_user == false) {
                this.is_followed_by_user = true;
            } else {
                this.is_followed_by_user = false;
            }

            $.ajax({
                'url': '/api/follows/' + horseID,
                success: function(message) {
                    toastr.success(message);
                }
            })
        }
    }
});
