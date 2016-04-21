var Vue = require('vue');

module.exports = Vue.extend({
    template: '#create-company',

    props: ['createcompany'],

    data: function() {
        return {
            name: '',
            street: '',
            zip: '',
            city: '',
            state: '',
            country: '',
            telephone: '',
            email: '',
            website: '',
            about: '',
            submitting: false,
            submitState: '',
            errors: [],
        }
    },

    ready: function() {

    },

    methods: {
        submit: function(e) {
            e.preventDefault();

            this.submitting = true;
            this.submitState = 'Processing...';

            var data = {
                "name": this.name,
                "street": this.street,
                "email": this.email,
                "telephone": this.telephone,
                "website": this.website,
                "about": this.about,
                "zip": this.zip,
                "country": this.country,
                "state": this.state,
                "city": this.city,
                "type": 1,
            }

            var vm = this;

            $.ajax({
                url: '/api/companies/',
                type: 'post',
                data: data,
                success: function(company) {
                    console.log(company);
                    vm.submitState = 'redirecting ...';
                    window.location.replace('/companies/' + company.data.slug);
                }.bind(vm),
                error: function(errors) {
                    vm.errors = errors.responseJSON.errors;
                    vm.submitting = false;
                }.bind(vm)
            })
        }
    }
});
