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
    },

    methods: {
        removeArticle: function (article) {
            this.articles.$remove(article);
            $.ajax({
                url: '/api/topics/' + topicId + '/articles/' + article.slug,
                type: 'post',
                data: {_method: 'delete'},
            });
        }
    }
});
