<?php
namespace EQM\Models\Wiki;

use EQM\Models\Wiki\Articles\ArticleRepository;
use EQM\Models\Wiki\Articles\EloquentArticle;
use EQM\Models\Wiki\Articles\EloquentArticleRepository;
use EQM\Models\Wiki\Topics\EloquentTopic;
use EQM\Models\Wiki\Topics\EloquentTopicRepository;
use EQM\Models\Wiki\Topics\TopicRepository;
use Illuminate\Support\ServiceProvider;

class WikiServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;
    
    public function register()
    {
        $this->app->singleton(TopicRepository::class, function() {
            return new EloquentTopicRepository(new EloquentTopic());
        });
        
        $this->app->singleton(ArticleRepository::class, function() {
            return new EloquentArticleRepository(new EloquentArticle());
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            TopicRepository::class,
            ArticleRepository::class,
        ];
    }
}
