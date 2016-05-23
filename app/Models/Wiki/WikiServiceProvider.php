<?php
namespace EQM\Models\Wiki;

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
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            TopicRepository::class,
        ];
    }
}
