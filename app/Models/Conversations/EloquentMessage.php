<?php
namespace EQM\Models\Conversations;

use Carbon\Carbon;
use EQM\Models\Users\EloquentUser;
use Illuminate\Database\Eloquent\Model;

class EloquentMessage extends Model implements Message
{
    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['body'];

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt()
    {
        return Carbon::parse($this->created_at);
    }

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt()
    {
        return Carbon::parse($this->updated_at);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversationRelation()
    {
        return $this->belongsTo(EloquentConversation::class, 'conversation_id');
    }

    /**
     * @return \EQM\Models\Conversations\Conversation
     */
    public function conversation()
    {
        return $this->conversationRelation()->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRelation()
    {
        return $this->belongsTo(EloquentUser::class, 'user_id', 'id');
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function user()
    {
        return $this->userRelation()->first();
    }
}
