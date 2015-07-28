<?php
namespace EQM\Models\Notifications;

use EQM\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const STATUS_LIKED = 1;
    const COMMENT_POSTED = 2;
    const PEDIGREE_CREATED = 3;

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

            case self::COMMENT_POSTED;
                return route('statuses.show', $entity->id);

            case self::PEDIGREE_CREATED:
                return route('horses.show', $entity->slug);
        }
    }

    public function markAsRead()
    {
        $this->read = true;
        $this->save();
    }
}
