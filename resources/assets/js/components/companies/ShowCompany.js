var Vue = require('vue');
var googleMaps = require('google-maps');

module.exports = Vue.extend({
    template: '#show-company',

    props: ['showcompany'],

    data: function() {
        return {
            company: {},
            address: {},
            users: [],
            horses: [],
            latLong: {},
            following: true,
        }
    },

    ready: function() {
        var companySlug = window.equimundo.company;

        $.getJSON('/api/companies/' + companySlug , function(company) {
            this.company = company.data;
            this.address = company.data.addressRelation.data;
        }.bind(this));

        $.getJSON('/api/companies/' + companySlug + '/users', function (users) {
            this.users = users.data;
        }.bind(this));
        
        $.getJSON('/api/companies/' + companySlug + '/horses', function(horses) {
            this.horses = horses.data;
        }.bind(this));

        this.latLong = {lat: parseFloat(window.equimundo.latitude), lng: parseFloat(window.equimundo.longitude)};

        this.loadMap(this.latLong);

        this.following = false;
    },

    methods: {
        follow: function() {
            this.following = true;

            var data = {
                type: 2,
                is_admin: false,
            }

            var vm = this;

            $.ajax({
                url: '/api/companies/' + vm.company.slug + '/users',
                type: 'post',
                data: data,
                success: function(user) {
                    vm.company.is_followed_by_user = true;
                    vm.users.push(user.data);
                    vm.following = false;
                }.bind(vm)
            });
        },

        unfollow: function() {
            var vm = this;

            $.get('/api/companies/' + vm.company.slug + '/users/' + window.equimundo.auth.user.id, function(record) {
                vm.users.$remove(record.data);
            }.bind(vm));

            $.ajax({
                url: '/api/companies/' + vm.company.slug + '/users/' + window.equimundo.auth.user.id,
                type: 'post',
                data: {_method: 'delete'},
                success: function() {
                    vm.company.is_followed_by_user = false;
                    vm.following = false;
                }.bind(vm)
            });
        },

        loadMap: function (latLong) {
            googleMaps.load(function (google) {
                var mapDiv = document.getElementById('map');
                var map = new google.maps.Map(mapDiv, {
                    center: latLong,
                    zoom: 14,
                    disableDefaultUI: true
                });

                var marker = new google.maps.Marker({
                    position: latLong,
                    map: map,
                });


                map.set('styles', [
                    {
                        featureType: 'road',
                        elementType: 'geometry.stroke',
                        stylers: [
                            { color: '#40c4a7' },
                            { weight: 0.6 },
                            { lightness: -34 }
                        ]
                    },
                    {
                        featureType: 'landscape',
                        elementType: 'all',
                        stylers: [
                            { color: '#40c4a7' },
                            { saturation: -47 },
                            { lightness: 19 },
                            { gamma: 3.53 }
                        ]
                    }
                ]);
            });
        }
    }
});
