<?php
namespace EQM\Core\Testing;

use EQM\Models\Advertising\Contacts\AdvertisingContact;
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

    /**
     * @param \EQM\Models\Advertising\Contacts\AdvertisingContact $contact
     * @param array $attributes
     * @return array
     */
    public function includedAdvertisingContact(AdvertisingContact $contact, $attributes = [])
    {
        return [
            'data' => array_merge([
                'id' => $contact->id(),
                'first_name' => $contact->firstName(),
                'last_name' => $contact->lastName(),
                'email' => $contact->email(),
                'telephone' => $contact->telephone(),
            ], $attributes)
        ];
    }
}
