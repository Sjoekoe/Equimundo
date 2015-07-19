<?php
namespace HorseStories\Models\Notifications;

use HorseStories\Models\Users\User;

class NotificationCreator
{
    /**
     * @var \HorseStories\Models\Notifications\Notification
     */
    private $notification;

    /**
     * @param \HorseStories\Models\Notifications\Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param \HorseStories\Models\Users\User $sender
     * @param \HorseStories\Models\Users\User $receiver
     * @param \HorseStories\Models\Notifications\Notification|int $type
     * @param $entity
     * @param array $data
     */
    public function create(User $sender, User $receiver, $type, $entity, $data)
    {
        $notification = new Notification();

        $notification->type = $type;
        $notification->sender_id = $sender->id;
        $notification->receiver_id = $receiver->id;
        $notification->link = $this->notification->getRoute($type, $entity);
        $notification->data = json_encode($data);

        $notification->save();
    }
}
