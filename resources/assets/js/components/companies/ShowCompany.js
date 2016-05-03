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
            userHorses: [],
            image: '',
            body: '',
            upload: '',
            submitting: false,
            errors: [],
            statuses: [],
            loading: true,
            page: 1,
            max_pages: 1,
            commenting: false,
            newComment: {
                comment: {

                },
            },
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

        $.getJSON('/api/companies/' + companySlug + '/statuses', function(statuses) {
            this.statuses = statuses.data;
            this.max_pages = statuses.meta.pagination.total_pages;
            this.loading = false;
        }.bind(this));

        this.latLong = {lat: parseFloat(window.equimundo.latitude), lng: parseFloat(window.equimundo.longitude)};

        this.loadMap(this.latLong);

        this.following = false;

        var vm = this;

        $(window).scroll(function() {
            if (vm.loading == false && vm.page < vm.max_pages) {
                if ($(document).height() <= ($(window).height() + $(window).scrollTop())) {
                    vm.loading = true;
                    vm.page += 1;

                    $.getJSON('/api/companies/' + companySlug + '/statuses?page=' + vm.page, function (statuses) {
                        vm.loading = false;
                        statuses.data.map(function (status) {
                            vm.statuses.push(status);
                        });
                    }.bind(vm));
                }
            }
        });
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
        },

        submit: function(e) {
            e.preventDefault();
            this.submitting = true;
            var form = document.querySelector('#picture');
            var file = form.files[0];
            var formData = new FormData();
            formData.append('body', this.body);
            this.image ? formData.append('picture', file) : formData.append('picture', 'undefined');
            var vm = this;

            $.ajax({
                url: '/api/companies/' + window.equimundo.company + '/statuses',
                type: 'post',
                data: formData,
                processData: false,
                contentType:false,
                success: function(status) {
                    vm.statuses.unshift(status.data);
                    vm.body = '';
                    vm.image = '';
                    vm.upload = '';
                    vm.submitting = false;
                }.bind(vm),
                error: function(errors) {
                    vm.errors = errors.responseJSON;
                    vm.submitting = false;
                }.bind(vm)
            })
        },

        onFileChange: function(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length) {
                return;
            }
            this.createImage(files[0]);
        },

        createImage: function(file) {
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            reader.onload = function(e) {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        removeImage: function (e) {
            this.image = '';
        },

        likeStatus: function(status) {
            if (status.liked_by_user) {
                status.like_count--;
                status.liked_by_user = false;
            } else {
                status.like_count++;
                status.liked_by_user = true;
            }

            $.ajax({
                url: '/api/statuses/' + status.id + '/like',
                type: 'post',
            });
        },

        deleteStatus: function(status) {
            this.statuses.$remove(status);
            $.ajax({
                url: '/api/statuses/' + status.id,
                type: 'post',
                data: {_method: 'delete'},
            });
        },

        deleteComment: function(status, comment) {
            status.comments.data.$remove(comment);
            $.ajax({
                url: '/api/statuses/' + status.id + '/comments/' + comment.id,
                type: 'post',
                data: {_method: 'delete'},
            });
        },

        postComment: function(e, status) {
            var comment_body;
            e.preventDefault();
            this.commenting = true;

            if (this.newComment !== '') {
                $.each(this.newComment.comment, function(ndx, value){
                    comment_body = value;
                });
            }

            var comment = {
                "body": comment_body
            }

            this.newComment = '';
            var vm = this;

            $.ajax({
                url: '/api/statuses/' + status.id + '/comments',
                type: 'post',
                data: comment,
                success: function(comment) {
                    status.comments.data.push(comment.data);
                    vm.commenting = false;
                },
                errors: function() {
                    vm.commenting = false;
                }
            })
        },

        likeComment: function(comment) {
            if (comment.liked_by_user) {
                comment.like_count--;
                comment.liked_by_user = false;
            } else {
                comment.like_count++;
                comment.liked_by_user = true;
            }

            $.ajax({
                url: '/api/comments/' + comment.id + '/like',
                type: 'post',
            });
        },
    }
});
