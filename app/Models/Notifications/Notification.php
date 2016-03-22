<?php
namespace EQM\Models\Notifications;

interface Notification
{
    const STATUS_LIKED = 1;
    const COMMENT_POSTED = 2;
    const PEDIGREE_CREATED = 3;
    const COMMENT_LIKED = 4;
    const HORSE_FOLLOWED = 5;

    /**
     * @return int
     */
    public function id();

    /**
     * @return int
     */
    public function type();

    /**
     * @return string
     */
    public function link();

    /**
     * @return \EQM\Models\Users\User
     */
    public function sender();

    /**
     * @return \EQM\Models\Users\User
     */
    public function receiver();

    /**
     * @return string
     */
    public function data();

    /**
     * @return bool
     */
    public function isRead();

    /**
     * @return bool
     */
    public function isUnread();

    public function markAsRead();

    /**
     * @param static $type
     * @param $entity
     * @return string
     */
    public function getRoute($type, $entity);

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();
}
