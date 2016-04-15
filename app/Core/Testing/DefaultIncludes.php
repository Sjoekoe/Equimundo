<?php
namespace EQM\Core\Testing;

use EQM\Models\Addresses\Address;
use EQM\Models\Advertising\Contacts\AdvertisingContact;
use EQM\Models\Companies\Company;
use EQM\Models\Companies\Horses\CompanyHorse;
use EQM\Models\Companies\Users\CompanyUser;
use EQM\Models\Horses\Horse;
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
            'profile_picture' =>  'http://localhost/images/eqm.png',
        ], $attributes);
    }
}
