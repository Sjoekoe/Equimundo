<?php
namespace EQM\Core\Testing;

use EQM\Models\Addresses\Address;
use EQM\Models\Advertising\Contacts\AdvertisingContact;
use EQM\Models\Companies\Company;
use EQM\Models\Companies\Horses\CompanyHorse;
use EQM\Models\Companies\Users\CompanyUser;
use EQM\Models\Conversations\Conversation;
use EQM\Models\Conversations\Message;
use EQM\Models\Horses\Horse;
use EQM\Models\Notifications\Notification;
use EQM\Models\Statuses\Status;
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

    /**
     * @param \EQM\Models\Companies\Company $company
     * @param array $attributes
     * @return array
     */
    public function includedCompany(Company $company, $attributes = [])
    {
        return array_merge([
            'id' => $company->id(),
            'name' => $company->name(),
            'slug' => $company->slug(),
            'website' => $company->website(),
            'telephone' => $company->telephone(),
            'about' => $company->about(),
            'email' => $company->email(),
            'is_followed_by_user' => false,
            'addressRelation' => [
                'data' => $this->includedAddress($company->address()),
            ]
        ], $attributes);
    }

    /**
     * @param \EQM\Models\Addresses\Address $address
     * @param array $attributes
     * @return array
     */
    public function includedAddress(Address $address, $attributes = [])
    {
        return array_merge([
            'id' => $address->id(),
            'street' => $address->street(),
            'city' => $address->city(),
            'zip' => $address->zip(),
            'state' => $address->state(),
            'country' => $address->country(),
            'latitude' => $address->latitude(),
            'longitude' => $address->longitude(),
        ], $attributes);
    }

    /**
     * @param \EQM\Models\Companies\Users\CompanyUser $companyUser
     * @param array $attributes
     * @return array
     */
    public function includedCompanyUser(CompanyUser $companyUser, $attributes = [])
    {
        return array_merge([
            'id' => $companyUser->id(),
            'is_admin' => false,
            'userRelation' => $this->includedUser($companyUser->user()),
            'companyRelation' => [
                'data' => $this->includedCompany($companyUser->company())
            ]
        ], $attributes);
    }

    /**
     * @param \EQM\Models\Companies\Horses\CompanyHorse $companyHorse
     * @param array $attributes
     * @return array
     */
    public function includedCompanyHorse(CompanyHorse $companyHorse, $attributes = [])
    {
        return array_merge([
            'id' => $companyHorse->id(),
            'companyRelation' => [
                'data' => $this->includedCompany($companyHorse->company()),
            ],
            'horseRelation' => [
                'data' => $this->includedHorse($companyHorse->horse()),
            ]
        ], $attributes);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $attributes
     * @return array
     */
    public function includedHorse(Horse $horse, $attributes = [])
    {
        return array_merge([
            'id' => $horse->id(),
            'name' => $horse->name(),
            'life_number' => $horse->lifeNumber(),
            'breed' => $horse->breed(),
            'height' => $horse->height(),
            'gender' => (int) $horse->gender(),
            'date_of_birth' => $horse->dateOfBirth()->toIso8601String(),
            'color' => (int) $horse->color(),
            'slug' => $horse->slug(),
            'is_followed_by_user' => false,
            'profile_picture' =>  'http://localhost/images/eqm.png',
        ], $attributes);
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @param array $attributes
     * @return array
     */
    public function includedCompanyStatus(Status $status, $attributes = [])
    {
        return array_merge([
            'id' => $status->id(),
            'body' => $status->body(),
            'created_at' => $status->createdAt()->toIso8601String(),
            'like_count' => 0,
            'prefix' => trans('statuses.prefixes.' . $status->prefix()),
            'liked_by_user' => false,
            'can_delete_status' => false,
            'picture' => null,
            'is_horse_status' => false,
            'comments' => [
                'data' => [],
            ],
            'poster' => [
                'data' => $this->includedCompany($status->company()),
            ],
        ], $attributes);
    }

    /**
     * @param \EQM\Models\Notifications\Notification $notification
     * @param array $attributes
     * @return array
     */
    public function includedNotification(Notification $notification, $attributes = [])
    {
        return array_merge([
            'id' => $notification->id(),
            'type' => $notification->type(),
            'url' => route('notifications.show', $notification->id()),
            'message' => trans('notifications.' . $notification->type(), json_decode($notification->data(), true)),
            'is_read' => (bool) $notification->isRead(),
            'icon' => config('notifications.' . $notification->type()),
            'created_at' => $notification->createdAt()->toIso8601String(),
            'receiverRelation' => $this->includedUser($notification->receiver()),
            'senderRelation' =>  $this->includedUser($notification->sender()),
        ], $attributes);
    }

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @param array $attributes
     * @return array
     */
    public function includedConversation(Conversation $conversation, $attributes = [])
    {
        return array_merge([
            'id' => $conversation->id(),
            'subject' => $conversation->subject(),
            'updated_at' => $conversation->updatedAt()->toIso8601String(),
        ], $attributes);
    }

    /**
     * @param \EQM\Models\Conversations\Message $message
     * @param array $attributes
     * @return array
     */
    public function includedMessage(Message $message, $attributes = [])
    {
        return array_merge([
            'id' => $message->id(),
            'body' => $message->body(),
            'made_by_user' => true,
            'created_at' => $message->createdAt()->toIso8601String(),
            'userRelation' => $this->includedUser($message->user()),
            'conversationRelation' => [
                'data' => $this->includedConversation($message->conversation())
            ],
        ], $attributes);
    }
}
