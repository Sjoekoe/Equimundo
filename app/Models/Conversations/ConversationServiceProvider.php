<?php
namespace EQM\Models\Conversations;

use Illuminate\Support\ServiceProvider;

class ConversationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ConversationRepository::class, function() {
            return new EloquentConversationRepository(new EloquentConversation());
        });

        $this->app->singleton(MessageRepository::class, function() {
            return new EloquentMessageRepository(new EloquentMessage());
        });
    }
}
