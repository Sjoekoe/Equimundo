<?php
namespace EQM\Models\Notifications;

use EQM\Models\Users\User;

class NotificationCreator
{
    /**
     * @var \EQM\Models\Notifications\EloquentNotification
     */
    private $notification;

    /**
     * @param \EQM\Models\Notifications\EloquentNotification $notification
     */
    public function __construct(EloquentNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param \EQM\Models\Users\User $sender
     * @param \EQM\Models\Users\User $receiver
     * @param \EQM\Models\Notifications\Notification|int $type
     * @param $entity
     * @param array $data
     * @return \EQM\Models\Notifications\Notification
     */
    public function create(User $sender, User $receiver, $type, $entity, $data)
    {
        $notification = new EloquentNotification();

        $notification->type = $type;
        $notification->sender_id = $sender->id;
        $notification->receiver_id = $receiver->id;
        $notification->link = $this->notification->getRoute($type, $entity);
        $notification->data = json_encode($data);

        $notification->save();

        return $notification;
    }
}
