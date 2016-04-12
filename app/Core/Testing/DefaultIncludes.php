<?php
namespace EQM\Core\Testing;

use EQM\Models\Addresses\Address;
use EQM\Models\Advertising\Contacts\AdvertisingContact;
use EQM\Models\Companies\Company;
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
}
