var Vue = require('vue');

module.exports = Vue.extend({
    template: '#create-advertisement',

    props: ['createadvertisement'],

    data: function() {
        return {
            company_id: '',
            start_date: '',
            end: '',
            type: '',
            amount: '',
            website: '',
            picture: '',
            options: [],
            status: 'Creating advertisement ...',
            submitting: false,
            errors: [],
        }
    },

    ready: function() {
        this.options = window.equimundo.companies;
    },

    methods: {
        Submit: function() {
            this.submitting = true;

            var form = document.querySelector('#picture');
            var file = form.files[0];
            var formData = new FormData();
            formData.append('company_id', this.company_id);
            formData.append('start', this.start_date);
            formData.append('end', this.end);
            formData.append('website', this.website);
            formData.append('amount', this.amount);
            formData.append('type', this.type);
            this.picture ? formData.append('picture', file) : formData.append('picture', 'null');

            var vm = this;

            $.ajax({
                url: '/api/admin/advertisements',
                type: 'post',
                data: formData,
                processData: false,
                contentType:false,
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
