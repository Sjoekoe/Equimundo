<?php
namespace HorseStories\Models\Notifications;

use HorseStories\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const STATUS_LIKED = 1;

    /**
     * @var array
     */
    protected $fillable = ['type', 'link'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function receiver()
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }

    /**
     * @return mixed
     */
    public function isRead()
    {
        return $this->read;
    }

    /**
     * @return bool
     */
    public function isUnread()
    {
        return ! $this->isRead();
    }

    /**
     * @param static $type
     * @param $entity
     * @return string
     */
    public function getRoute($type, $entity)
    {
        switch ($type) {
            case self::STATUS_LIKED:
                return route('statuses.show', $entity->id);
        }
    }

    public function markAsRead()
    {
        $this->read = true;
        $this->save();
    }
}
