var Vue = require('vue');
var topicId = window.equimundo.topic;

module.exports = Vue.extend({
    template: '#articles-table',

    props: ['articlestable'],

    data: function() {
        return {
            articles: [],
        }
    },

    ready: function() {
        $.getJSON('/api/topics/' + topicId + '/articles', function(articles) {
            this.articles = articles.data;
        }.bind(this));
    }
});
