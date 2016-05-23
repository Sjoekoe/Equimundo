<?php
namespace EQM\Api\Wiki\Articles;

use EQM\Api\Wiki\Topics\TopicTransformer;
use EQM\Models\Wiki\Articles\Article;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'topicRelation',
    ];

    /**
     * @param \EQM\Models\Wiki\Articles\Article $article
     * @return array
     */
    public function transform(Article $article)
    {
        return [
            'id' => $article->id(),
            'title' => $article->title(),
            'slug' => $article->slug(),
            'body' => $article->body(),
            'views' => $article->views(),
        ];
    }

    /**
     * @param \EQM\Models\Wiki\Articles\Article $article
     * @return \League\Fractal\Resource\Item
     */
    public function includeTopicRelation(Article $article)
    {
        return $this->item($article->topic(), new TopicTransformer());
    }
}
