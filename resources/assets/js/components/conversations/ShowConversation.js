var Vue = require('vue');
var conversationID = window.equimundo.conversation;

module.exports = Vue.extend({
    template: '#show-conversation',

    props: ['showconversation'],

    data: function() {
        return {
            messages: [],
            olderMessages: [],
            body: '',
            replying: false,
            loading: false,
            errors: [],
            page: 1,
            final_page_not_reached: true,
        }
    },

    watch: {
        'messages': function (val, oldVal) {
            var objDiv = document.getElementById("scrollable");
            objDiv.scrollTop = objDiv.scrollHeight;
        },
    },

    ready: function() {
        $.getJSON('/api/conversations/' + conversationID + '/messages', function (messages) {
            this.messages = messages.data;

            if (messages.meta.pagination.total_pages > this.page) {
                this.page += 1;
            } else {
                this.final_page_not_reached = false;
            }

        }.bind(this));
    },

    methods: {
        reply: function() {
            this.replying = true;
            this.errors = [];

            var data = {
                'body': this.body,
            }
            var vm = this;

            $.ajax({
                url: '/api/conversations/' + conversationID + '/messages',
                type: 'post',
                data: data,
                success: function(message) {
                    vm.messages.push(message.data);
                    vm.body = '',
                    vm.replying = false;

                    vm.scrollToBottom;
                }.bind(vm),
                error: function(errors) {
                    vm.errors = errors.responseJSON.errors;
                    vm.replying = false;
                }.bind(vm)
            });
        },

        loadOlder: function() {
            this.loading = true;

            var vm = this;

            $.getJSON('/api/conversations/' + conversationID + '/messages?page=' + this.page, function (messages) {
                messages.data.map(function (message) {
                    vm.olderMessages.push(message);
                });

                if (messages.meta.pagination.total_pages > vm.page) {
                    vm.page += 1;
                } else {
                    vm.final_page_not_reached = false;
                }
                vm.loading = false;
            }.bind(vm));
        }
    }
});
