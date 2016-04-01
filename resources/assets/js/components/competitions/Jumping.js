var Vue = require('vue');

module.exports = Vue.extend({
    template: '#jumping-form',

    props: ['jumping'],

    data: function() {
        return {
            sent: false,
            q1: '',
            q2: '',
            q3: '',
            email: '',
            name: '',
            submitting: false,
            errors: [],
        };
    },

    ready: function() {

    },

    methods: {
        submit: function() {
            this.submitting = true;

            var data = {
                'q1': this.q1,
                'q2': this.q2,
                'q3': this.q3,
                'email': this.email,
                'name': this.name,
            }

            var vm = this;

            $.ajax({
                url: '/api/competitions/jumping-antwerpen-2016',
                type: 'post',
                data: data,
                success: function() {
                    vm.sent = true
                },
                error: function(errors) {
                    vm.errors = errors.responseJSON;
                    vm.submitting = false;
                }
            })
        }
    }
});
