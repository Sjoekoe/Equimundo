var Vue = require('vue');

module.exports = Vue.extend({
    template: '#create-advertisement',

    props: ['createadvertisement'],

    data: function() {
        return {
            company_id: '',
            start: '',
            end: '',
            type: 1,
            amount: '',
            website: '',
            options: [],
            status: 'Creating advertisement ...',
            submitting: false,
        }
    },

    ready: function() {
        this.options = window.equimundo.companies;
    },

    methods: {
        Submit: function() {
            this.submitting = true;

            var data = {
                "company_id": this.company_id,
                "start": this.start,
                "end": this.end,
                "website": this.website,
                "amount": this.amount,
                "type": this.type,
            }

            var vm = this;

            $.ajax({
                url: '/api/admin/advertisements',
                type: 'post',
                data: data,
                success: function() {
                    vm.status = 'Redirecting ...';
                    window.location.replace("/admin/advertisements");
                }.bind(vm),
                error: function(errors) {
                    vm.errors = errors.responseJSON;
                    vm.submitting = false;
                }.bind(vm)
            })
        }
    }
});
