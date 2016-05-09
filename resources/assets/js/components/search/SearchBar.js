var Vue = require('vue');
var Algolia = require('algoliasearch');

module.exports = Vue.extend({
    template: '#searchbar',

    props: ['searchbar'],

    data: function() {
        return {
            query: '',
            horses: [],
            users: [],
            companies: [],
        };
    },

    ready: function() {
        this.client = Algolia(window.algolia_id, window.algolia_app_id);
        this.horseIndex = this.client.initIndex('horses');
        this.userIndex = this.client.initIndex('users');
        this.companyIndex = this.client.initIndex('companies');

        $('#typeahead').typeahead({
            highlight: true
        }, {
            name: 'Horses',
            source: this.horseIndex.ttAdapter(),
            displayKey: 'name',
            templates: {
                header: '<h3 style="padding-left: 1em;">Horses</h3> </hr>',
                suggestion: function(hit) {
                    return '<p>' + hit.name + '</p>';
                }
            }
        }, {
            name: 'Users',
            source: this.userIndex.ttAdapter(),
            display: 'first_name',
            templates: {
                header: '<h3 style="padding-left: 1em;">Users</h3> </hr>',
                suggestion: function (hit) {
                    return '<p>' + hit.first_name + ' ' + hit.last_name + '</p>';
                }
            }
        }, {
            name: 'Companies',
            source : this.companyIndex.ttAdapter(),
            displayKey: 'name',
            templates: {
                header: '<h3 style="padding-left: 1em;">Companies / Groups</h3> </hr>',
                suggestion: function(hit) {
                    return '<p>' + hit . name + '</p>';
                }
            }
        }).on('typeahead:select', function(e, suggestion) {
            this.query = suggestion.name ? suggestion.name : suggestion.first_name + ' ' + suggestion.last_name;
        }.bind(this));
    },

    methods: {
        search: function() {
            this.horseIndex.search(this.query, function(error, results) {
                this.horses = results.hits;
            }.bind(this));

            this.userIndex.search(this.query, function(error, results) {
                this.users = results.hits;
            }.bind(this));

            this.companyIndex.search(this.query, function(error, results) {
                this.companies = results.hits;
            }.bind(this));
        },

        submit: function() {
            window.location.replace("/search/results?search=" + this.query);
        }
    }
});
