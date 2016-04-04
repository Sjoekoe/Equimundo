var Vue = require('vue');

module.exports = Vue.extend({
    template: '#create-advertising-company',

    props: ['createadvertisingcompany'],

    data: function() {
        return {
            first_name: '',
            last_name: '',
            email: '',
            telephone: '',
            name: '',
            company_email: '',
            company_telephone: '',
            tax: '',
            street: '',
            zip: '',
            city: '',
            state: '',
            country: '',
            submitting: false,
            status: 'Creating Contact ...',
            contact: {},
            address: {},
        }
    },

    ready: function() {

    },

    methods: {
        Submit: function() {
            this.submitting = true;
            this.createContact();
        },

        createContact: function() {
            var data = {
                "first_name": this.first_name,
                "last_name": this.last_name,
                "email": this.email,
                "telephone": this.telephone,
            }
            var vm = this;

            $.ajax({
                url: '/api/admin/advertisements/contacts',
                type: 'post',
                data: data,
                success: function(contact) {
                    vm.contact = contact.data;
                    vm.createAddress();
                }.bind(vm),
                error: function(errors) {
                    vm.errors = errors.responseJSON;
                    vm.submitting = false;
                }.bind(vm)
            })
        },

        createAddress: function() {
            this.status = 'Creating Address ...';
            var data = {
                "street": this.street,
                "zip": this.zip,
                "city": this.city,
                "state": this.state,
                "country": this.country,
            }
            var vm = this;

            $.ajax({
                url: '/api/addresses/',
                type: 'post',
                data: data,
                success: function(address) {
                    vm.address = address.data;
                    vm.createCompany();
                }.bind(vm),
                error: function(errors) {
                    vm.errors = errors.responseJSON;
                    vm.submitting = false;
                }.bind(vm)
            })
        },

        createCompany: function() {
            this.status = 'Creating Company ...';
            var data = {
                "name": this.name,
                "telephone": this.company_telephone,
                "email": this.company_email,
                "tax": this.tax,
                "adv_contact_id": this.contact.id
            }
            var vm = this;

            $.ajax({
                url: '/api/admin/advertisements/companies',
                type: 'post',
                data: data,
                success: function(company) {
                    vm.status = 'Redirecting ...';
                    window.location.replace("/admin/advertisements/companies");
                }.bind(vm),
                error: function(errors) {
                    vm.errors = errors.responseJSON;
                    vm.submitting = false;
                }.bind(vm)
            })
        }
    }
});
