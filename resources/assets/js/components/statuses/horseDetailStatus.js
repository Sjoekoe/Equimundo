var Vue = require('vue');

module.exports = Vue.extend({
    template: '#horse-status-template',

    props: ['horsestatus'],

    data: function() {
        return {
            body: '',
            submitting: false,
            statuses: [],
            errors: [],
            commenting: false,
            upload: '',
            image: '',
            hideNoStatusesText: true,
            newComment: {
                comment: {

                },
            },
        }
    },

    ready: function() {

    },

    methods: {
        submit: function(e) {
            e.preventDefault();
            this.submitting = true;
            var form = document.querySelector('#picture');
            var file = form.files[0];
            var formData = new FormData();
            formData.append('body', this.body);
            formData.append('horse', window.horse_id);
            this.image ? formData.append('picture', file) : formData.append('picture', 'undefined');
            var vm = this;

            $.ajax({
                url: '/api/statuses/',
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
                error: function() {
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
