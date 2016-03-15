var Vue = require('vue');

module.exports = Vue.extend({
    template: '#horse-feed-template',

    props: ['horsefeed'],

    data: function() {
        return {
            statuses: [],
            loading: true,
            page: 1,
            newComment: {
                comment: {

                },
            }
        }
    },

    ready: function(){
        $.getJSON('/api/horses/' + window.horse_id + '/statuses', function(statuses) {
            this.loading = false;
            this.statuses = statuses.data;
        }.bind(this));

        var vm = this;

        $(window).scroll(function() {
            if ($(document).height() <= ($(window).height() + $(window).scrollTop())) {
                vm.loading = true;
                vm.page += 1;

                $.getJSON('/api/horses/' + window.horse_id + '/statuses?page=' + vm.page, function(statuses) {
                    vm.loading = false;
                    statuses.data.map(function(status) {
                        vm.statuses.push(status);
                    });
                }.bind(vm));
            }
        });
    },

    methods: {
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

            $.each(this.newComment.comment, function(ndx, value){
                comment_body = value;
            });

            var comment = {
                "body": comment_body
            }

            this.newComment = '';

            $.ajax({
                url: '/api/statuses/' + status.id + '/comments',
                type: 'post',
                data: comment,
                success: function(comment) {
                    status.comments.data.push(comment.data);
                }
            })
        }
    }
});
