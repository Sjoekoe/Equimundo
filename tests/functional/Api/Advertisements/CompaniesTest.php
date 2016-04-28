<?php
namespace functional\Api\Advertisements;

use DB;
use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Advertising\Companies\AdvertisingCompany;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CompaniesTest extends \TestCase
{
    use DefaultIncludes, DatabaseTransactions;

    /** @test */
    function it_can_get_all_companies()
    {
        $address = $this->createAddress();
        $contact = $this->createAdvertisingContact();
        $company = $this->createAdvertisingCompany([
            'adv_contact_id' => $contact->id(),
            'address_id' => $address->id(),
        ]);

        $this->get('/api/admin/advertisements/companies')
            ->seeJsonEquals([
                'data' => [
                    [
                        'id' => $company->id(),
                        'name' => $company->name(),
                        'email' => $company->email(),
                        'telephone' => $company->telephone(),
                        'tax' => $company->tax(),
                        'contactRelation' => $this->includedAdvertisingContact($contact),
                        'addressRelation' => [
                            'data' => [
                                'id' => $address->id(),
                                'street' => $address->street(),
                                'zip' => $address->zip(),
                                'city' => $address->city(),
                                'state' => $address->state(),
                                'country' => $address->country(),
                                'longitude' => $address->longitude(),
                                'latitude' => $address->latitude(),
                            ]
                        ]
                    ]
                ],
                'meta' => [
                    'pagination' => [
                        'count' => 1,
                        'current_page' => 1,
                        'links' => [],
                        'per_page' => 10,
                        'total' => 1,
                        'total_pages' => 1,
                    ],
                ],
            ]);
    }

    /** @test */
    function it_can_create_an_advertising_company()
    {
        $address = $this->createAddress();
        $contact = $this->createAdvertisingContact();

        $this->post('/api/admin/advertisements/companies', [
            'address_id' => $address->id(),
            'adv_contact_id' => $contact->id(),
            'name' => 'Test Company',
            'tax' => '09876',
            'telephone' => '4567893',
            'email' => 'test@test.com',
        ])->seeJsonEquals([
            'data' => [
                'id' => DB::table(AdvertisingCompany::TABLE)->first()->id,
                'name' => 'Test Company',
                'email' => 'test@test.com',
                'telephone' => '4567893',
                'tax' => '09876',
                'contactRelation' => $this->includedAdvertisingContact($contact),
                'addressRelation' => [
                    'data' => [
                        'id' => $address->id(),
                        'street' => $address->street(),
                        'zip' => $address->zip(),
                        'city' => $address->city(),
                        'state' => $address->state(),
                        'country' => $address->country(),
                        'longitude' => $address->longitude(),
                        'latitude' => $address->latitude(),
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    function it_can_show_an_advertising_company()
    {
        $address = $this->createAddress();
        $contact = $this->createAdvertisingContact();
        $company = $this->createAdvertisingCompany([
            'address_id' => $address->id(),
            'adv_contact_id' => $contact->id(),
        ]);

        $this->get('/api/admin/advertisements/companies/' . $company->id())
            ->seeJsonEquals([
                'data' => [
                    'id' => $company->id(),
                    'name' => $company->name(),
                    'email' => $company->email(),
                    'telephone' => $company->telephone(),
                    'tax' => $company->tax(),
                    'contactRelation' => $this->includedAdvertisingContact($contact),
                    'addressRelation' => [
                        'data' => [
                            'id' => $address->id(),
                            'street' => $address->street(),
                            'zip' => $address->zip(),
                            'city' => $address->city(),
                            'state' => $address->state(),
                            'country' => $address->country(),
                            'longitude' => $address->longitude(),
                            'latitude' => $address->latitude(),
                        ]
                    ]
                ],
            ]);
    }

    /** @test */
    function it_can_edit_and_advertising_company()
    {
        $address = $this->createAddress();
        $contact = $this->createAdvertisingContact();
        $company = $this->createAdvertisingCompany([
            'address_id' => $address->id(),
            'adv_contact_id' => $contact->id(),
        ]);

        $this->put('/api/admin/advertisements/companies/' . $company->id(), [
            'name' => 'blablabla',
            'email' => 'email@company.com',
            'telephone' => '53780',
            'tax' => '4175'
        ])->seeJsonEquals([
            'data' => [
                'id' => $company->id(),
                'name' => 'blablabla',
                'email' => 'email@company.com',
                'telephone' => '53780',
                'tax' => '4175',
                'contactRelation' => $this->includedAdvertisingContact($contact),
                'addressRelation' => [
                    'data' => [
                        'id' => $address->id(),
                        'street' => $address->street(),
                        'zip' => $address->zip(),
                        'city' => $address->city(),
                        'state' => $address->state(),
                        'country' => $address->country(),
                        'longitude' => $address->longitude(),
                        'latitude' => $address->latitude(),
                    ]
                ]
            ]
            ]);
    }

    /** @test */
    function it_can_delete_an_advertising_company()
    {
        $address = $this->createAddress();
        $contact = $this->createAdvertisingContact();
        $company = $this->createAdvertisingCompany([
            'address_id' => $address->id(),
            'adv_contact_id' => $contact->id(),
        ]);

        $this->seeInDatabase(AdvertisingCompany::TABLE, [
            'id' => $company->id(),
        ]);

        $this->delete('/api/admin/advertisements/companies/' . $company->id())
            ->assertResponseStatus(204);

        $this->notSeeInDatabase(AdvertisingCompany::TABLE, [
            'id' => $company->id(),
        ]);
    }
}
