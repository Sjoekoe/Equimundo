var Vue = require('vue');

module.exports = Vue.extend({
    template: '#single-status',

    props: ['singlestatus'],

    data: function() {
        return {
            statuses: [],
            commenting: false,
            newComment: {
                comment: {

                },
            },
        }
    },

    ready: function() {
        $.getJSON('/api/statuses/' + window.status_id, function(status) {
            this.statuses.push(status.data);
        }.bind(this));
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
                error: function() {
                    vm.commenting = false;
                }
            })
        }
    }
});
