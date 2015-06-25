<?php
namespace HorseStories\Models\Conversations;

use HorseStories\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'conversation_messages';

    protected $fillable = ['body'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
