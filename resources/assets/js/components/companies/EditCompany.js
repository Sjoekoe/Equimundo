var Vue = require('vue');
var company = window.equimundo.company;

module.exports = Vue.extend({
    template: '#edit-company',

    props: ['editcompany'],

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
            fetching: true
        }
    },

    ready: function() {
        $.getJSON('/api/companies/' + company, function (company) {
            var address = company.data.addressRelation.data;
            this.name = company.data.name;
            this.email = company.data.email;
            this.website = company.data.website;
            this.telephone = company.data.telephone;
            this.about = company.data.about;
            this.street = address.street;
            this.zip = address.zip;
            this.state = address.state;
            this.country = address.country;
            this.city = address.city;
            this.fetching = false;
        }.bind(this));
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
                url: '/api/companies/' + company,
                type: 'put',
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
