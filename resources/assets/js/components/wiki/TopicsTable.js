var Vue = require('vue');

module.exports = Vue.extend({
    template: '#wiki-topics-table',

    props: ['wikitopicstable'],

    data: function() {
        return {
            topics: [],
            newTitle: '',
            creating: false,
            errors: [],
            createModus: true,
            indexKey: '',
            updateId: '',
        }
    },

    ready: function() {
        $.getJSON('/api/topics', function(topics) {
            this.topics = topics.data;
        }.bind(this));
    },

    methods: {
        createTopic: function() {
            this.creating = true;

            var data = {
                "title": this.newTitle,
            }

            var vm = this;

            $.ajax({
                url: '/api/topics',
                method: 'POST',
                data: data,
                success: function(topic) {
                    vm.topics.push(topic.data);

                    $('#add-topic').css({
                        display: 'none',
                    });
                    $("body").removeClass("modal-open");
                    vm.newTitle = '';
                    vm.creating = false;
                }.bind(vm),
                error: function(errors) {
                    vm.errors = errors.responseJSON;
                    vm.creating = false;
                }.bind(vm)
            })
        },

        removeTopic: function (topic) {
            this.topics.$remove(topic);
            $.ajax({
                url: '/api/topics/' + topic.id,
                type: 'post',
                data: {_method: 'delete'},
            });
        },

        fillUpdatedValues: function(index, topic) {
            this.createModus = false;
            this.updateId = topic.id;
            this.newTitle = topic.title;
            this.indexKey = index;
        },

        updateTopic: function() {
            this.creating = true;

            var data = {
                "title": this.newTitle,
            }

            var vm = this;

            $.ajax({
                url: '/api/topics/' + this.updateId,
                method: 'PUT',
                data: data,
                success: function(topic) {
                    vm.topics[vm.indexKey].title = topic.data.title;

                    $('#add-topic').css({
                        display: 'none',
                    });
                    $("body").removeClass("modal-open");
                    vm.newTitle = '';
                    vm.creating = false;
                    vm.createModus = true;
                }.bind(vm),
                error: function(errors) {
                    vm.errors = errors.responseJSON;
                    vm.creating = false;
                }.bind(vm)
            })
        }
    }
});
