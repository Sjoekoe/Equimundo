var Vue = require('vue');
var googleMaps = require('google-maps');

module.exports = Vue.extend({
    template: '#show-company',

    props: ['showcompany'],

    data: function() {
        return {
            company: {},
            address: {},
            latLong: {},
        }
    },

    ready: function() {
        $.getJSON('/api/companies/' + window.equimundo.company + '?include=userRelation', function(company) {
            this.company = company.data;
            this.address = company.data.addressRelation.data;
        }.bind(this));

        this.latLong = {lat: parseFloat(window.equimundo.latitude), lng: parseFloat(window.equimundo.longitude)};

        var vm = this;
        googleMaps.load(function (google) {
            var mapDiv = document.getElementById('map');
            console.log(mapDiv);
            var map = new google.maps.Map(mapDiv, {
                center: vm.latLong,
                zoom: 14,
                disableDefaultUI: true
            });

            var marker = new google.maps.Marker({
                position: vm.latLong,
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

        //setTimeout(this.setMap, 100);
    },
});
