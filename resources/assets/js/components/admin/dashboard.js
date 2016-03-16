var Vue = require('vue');
var Pusher = require('pusher-js');

module.exports = Vue.extend({
    template: '#admindash',

    props: ['admindash'],

    data: function() {
        return {
            invites: window.invites,
            comments: window.comments,
            likes: window.likes,
            users: window.users,
        };
    },

    ready: function() {
        this.pusher = new Pusher('50125ce9622090efbd5a');
        this.pusherChannel = this.pusher.subscribe('admin-dashboard');

        this.pusherChannel.bind('EQM\\Events\\InvitationWasSent', function() {
            this.invites +=1;
        });

        this.pusherChannel.bind('EQM\\Events\\CommentWasPosted', function() {
            this.comments +=1;
        });

        this.pusherChannel.bind('EQM\\Events\\StatusLiked', function() {
            this.likes +=1;
        });

        this.pusherChannel.bind('EQM\\Events\\UserRegistered', function() {
            this.users +=1;
        });
    }
});
