var Vue = require('vue');
var Algolia = require('algoliasearch');

module.exports = Vue.extend({
    template: '#searchbar',

    props: ['searchbar'],

    data: function() {
        return {
            query: '',
            horses: [],
            users: []
        };
    },

    ready: function() {
        this.client = Algolia("7V1YC3S2X5", "79e7674bda3dae6c35ceed58f7f52789");
        this.horseIndex = this.client.initIndex('horses');
        this.userIndex = this.client.initIndex('users');

        $('#typeahead').typeahead({
            highlight: true
        }, {
            name: 'Horses',
            source: this.horseIndex.ttAdapter(),
            displayKey: 'name',
            templates: {
                header: '<h3 class="panel-title">Horses</h3>',
                suggestion: function(hit) {
                    return '<p>' + hit.name + '</p>';
                }
            }
        }, {
            name: 'Users',
            source: this.userIndex.ttAdapter(),
            display: 'first_name',
            templates: {
                header: '<h3 class="panel-title">Users</h3>',
                suggestion: function(hit) {
                    return '<p>' + hit.first_name + ' ' + hit.last_name + '</p>';
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
        },

        submit: function() {
            window.location.replace("/search/results?search=" + this.query);
        }
    }
});
