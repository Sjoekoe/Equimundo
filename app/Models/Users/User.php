<?php
namespace EQM\Models\Users;

use Carbon\Carbon;
use EQM\Models\Conversations\Conversation;
use EQM\Models\Horses\Horse;
use EQM\Models\Roles\Role;

interface User
{
    const TABLE = 'users';

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function email();

    /**
     * @return string
     */
    public function firstName();

    /**
     * @return string
     */
    public function lastName();

    /**
     * @return \Carbon\Carbon
     */
    public function dateOfBirth();

    /**
     * @return string
     */
    public function country();

    /**
     * @return string
     */
    public function gender();

    /**
     * @return string
     */
    public function about();

    /**
     * @return string
     */
    public function rememberToken();

    /**
     * @return string
     */
    public function dateFormat();

    /**
     * @return bool
     */
    public function emailNotifications();

    /**
     * @return string
     */
    public function language();

    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function horses();

    /**
     * @return \EQM\Models\HorseTeams\HorseTeam[]
     */
    public function horseTeams();

    /**
     * @return \EQM\Models\Statuses\Status[]
     */
    public function statuses();

    /**
     * @return \EQM\Models\Comments\Comment[]
     */
    public function comments();

    /**
     * @return \EQM\Models\Statuses\Status[]
     */
    public function likes();

    /**
     * @return \EQM\Models\Comments\Comment
     */
    public function commentLikes();

    /**
     * @return \EQM\Models\Events\Event[]
     */
    public function events();

    /**
     * @return \EQM\Models\Roles\Role[]
     */
    public function roles();

    /**
     * @return \EQM\Models\Conversations\Conversation[]
     */
    public function conversations();

    /**
     * @return \EQM\Models\Notifications\Notification[]
     */
    public function notifications();

    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function follows();

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole($role);

    /**
     * @param \EQM\Models\Roles\Role $role
     */
    public function assignRole(Role $role);

    /**
     * @param \EQM\Models\Roles\Role $role
     */
    public function removeRole(Role $role);

    /**
     * @return bool
     */
    public function isAdmin();

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     */
    public function addConversation(Conversation $conversation);

    /**
     * @return bool
     */
    public function hasUnreadMessages();

    /**
     * @return int
     */
    public function countUnreadMessages();

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return bool
     */
    public function isInHorseTeam(Horse $horse);

    /**
     * @return bool
     */
    public function hasUnreadNotifications();

    /**
     * @return int
     */
    public function countUnreadNotifications();

    public function markNotificationsAsRead();

    /**
     * @return string
     */
    public function fullName();

    /**
     * @param \EQM\Models\Horses\Horse $horse
     */
    public function follow(Horse $horse);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return mixed
     */
    public function unFollow(Horse $horse);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return bool
     */
    public function isFollowing(Horse $horse);

    /**
     * @return bool
     */
    public function activated();

    /**
     * @return string
     */
    public function facebook();

    /**
     * @return string
     */
    public function twitter();

    /**
     * @return string
     */
    public function website();

    /**
     * @return string
     */
    public function activationKey();

    /**
     * @return string
     */
    public function slug();

    /**
     * @return \Carbon\Carbon
     */
    public function lastLogin();

    /**
     * @return string
     */
    public function ip();

    /**
     * @return int
     */
    public function unreadNotifications();

    /**
     * @return string
     */
    public function timezone();
}
