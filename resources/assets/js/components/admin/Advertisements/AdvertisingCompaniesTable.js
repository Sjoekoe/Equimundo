var Vue = require('vue');

module.exports = Vue.extend({
    template: '#advertising-companies',

    props: ['advertisingcompaniestable'],

    data: function() {
        return {
            companies: [],
        }
    },

    ready: function() {
        $.getJSON('/api/admin/advertisements/companies', function(companies) {
            this.companies = companies.data;
        }.bind(this));
    },

    methods: {
        delete: function(company) {
            this.companies.$remove(company);
            $.ajax({
                url: '/api/admin/advertisements/companies/' + company.id,
                type: 'post',
                data: {_method: 'delete'},
            });
        }
    }
});
