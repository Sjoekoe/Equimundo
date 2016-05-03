var Vue = require('vue');

module.exports = Vue.extend({
    template: '#status-creator',

    props: ['statuscreator'],

    data: function() {
       return {
           options: [],
           statuses: [],
           currentPicture: '',
           selected: '',
           selectedId: '',
           image: '',
           body: '',
           submitting: false,
           errors: [],
           commenting: false,
           upload: '',
           hideNoStatusesText: true,
           newComment: {
               comment: {

               },
           },
       }
    },

    ready: function() {
        $.getJSON('/api/users/' + window.user_id + '/horses', function(horses) {
            this.options = horses.data;
            this.selected = horses.data[0].name;
            this.selectedId = horses.data[0].id;
            this.currentPicture = horses.data[0].profile_picture;
        }.bind(this));
    },

    methods: {
        changeImage: function() {
            $.getJSON('/api/horses/' + this.selected, function(horse) {
                this.currentPicture = horse.data.profile_picture;
            }.bind(this));
        },

        submit: function(e) {
            e.preventDefault();
            this.submitting = true;
            var form = document.querySelector('#picture');
            var file = form.files[0];
            var formData = new FormData();
            formData.append('body', this.body);
            formData.append('horse', this.selected);
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
        }
    }
});
