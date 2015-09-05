<?php
namespace EQM\Models\Comments;

use Illuminate\Support\ServiceProvider;

class CommentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CommentRepository::class, function() {
            return new EloquentCommentRepository(new EloquentComment());
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [CommentRepository::class];
    }
}
