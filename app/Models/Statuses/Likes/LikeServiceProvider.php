<?php
namespace EQM\Models\Statuses\Likes;

use Illuminate\Support\ServiceProvider;

class LikeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(LikeRepository::class, EloquentLikeRepository::class);
    }
}
