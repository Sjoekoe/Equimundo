<?php
namespace EQM\Core\Testing;

use EQM\Models\Users\User;

trait DefaultIncludes
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param array $attributes
     * @return array
     */
    public function includedUser(User $user, $attributes = [])
    {
        return [
            'data' => array_merge([
                'id' => $user->id(),
                'first_name' => $user->firstName(),
                'last_name' => $user->lastName(),
                'email' => $user->email(),
                'date_of_birth' => null,
                'gender' => $user->gender(),
                'country' => $user->country(),
                'is_admin' => $user->isAdmin(),
                'language' => $user->language(),
                'slug' => $user->slug(),
                'unread_notifications' => $user->unreadNotifications(),
            ], $attributes),
        ];
    }
}
