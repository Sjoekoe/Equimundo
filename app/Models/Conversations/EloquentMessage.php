<?php
namespace EQM\Models\Conversations;

use EQM\Models\Users\User;
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(EloquentConversation::class, 'conversation_id')->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }
}
