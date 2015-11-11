<?php
namespace EQM\Models\Conversations;

use EQM\Models\Users\EloquentUser;
use Illuminate\Database\Eloquent\Model;

class EloquentMessage extends Model implements Message
{
    /**
     * @var string
     */
    protected $table = 'conversation_messages';

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
     * @return \DateTime
     */
    public function createdAt()
    {
        return $this->created_at;
    }

    /**
     * @return \DateTime
     */
    public function updatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return \EQM\Models\Conversations\Conversation
     */
    public function conversation()
    {
        return $this->belongsTo(EloquentConversation::class, 'conversation_id')->first();
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function user()
    {
        return $this->belongsTo(EloquentUser::class)->first();
    }
}
