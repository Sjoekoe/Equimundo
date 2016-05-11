var Vue = require('vue');
var userId = window.equimundo.auth ? window.equimundo.auth.user.id : null;
var show = window.equimundo.auth ? window.equimundo.auth.user.show_sidebar : false;

module.exports = Vue.extend({
    template: '#sidebar-button',

    props: ['sidebarbutton'],

    data: function() {
        return {
            state: show,
        }
    },

    ready: function() {

    },

    methods: {
        toggleSidebar: function() {
            var newState = this.state ? false : true;
            this.state = newState;

            var data = {
                "sidebar_collapsed": newState,
            }

            $.ajax({
                url: '/api/users/' + userId,
                type: 'put',
                data: data,
            })
        }
    }
});
