<?php
namespace EQM\Models\Notifications;

use EQM\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class EloquentNotification extends Model implements Notification
{
    /**
     * @var string
     */
    protected $table = 'notifications';

    /**
     * @var array
     */
    protected $fillable = ['type', 'link'];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function link()
    {
        return $this->link;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id')->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function receiver()
    {
        return $this->hasOne(User::class, 'id', 'receiver_id')->first();
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

    public function markAsRead()
    {
        $this->read = true;
        $this->save();
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
}
