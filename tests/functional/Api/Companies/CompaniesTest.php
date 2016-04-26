<?php
namespace functional\Api\Companies;

use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Companies\Company;
use EQM\Models\Companies\Stable;
use EQM\Models\Companies\Users\TeamMember;

class CompaniesTest extends \TestCase
{
    use DefaultIncludes;

    /** @test */
    function it_can_show_all_companies_paginated()
    {
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);

        $this->get('api/companies')
            ->seeJsonEquals([
                'data' => [
                    $this->includedCompany($company),
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
    function it_can_create_a_company()
    {
        $user = $this->loginAsUser();

        $this->post('/api/companies', [
            'name' => 'Test Company',
            'telephone' => '12345',
            'website' => 'www.test.com',
            'email' => 'test@test.com',
            'about' => 'lorem ipsum',
            'street' => 'Puttingstraat 8',
            'zip' => '4564BJ',
            'city' => 'Sint Jansteen',
            'state' => 'Zeeland',
            'country' => 'NL',
            'type' => Stable::ID,
        ])->seeJsonEquals([
            'data' => [
                'id' => 1,
                'name' => 'Test Company',
                'slug' => 'test-company',
                'telephone' => '12345',
                'about' => 'lorem ipsum',
                'email' => 'test@test.com',
                'website' => 'http://www.test.com',
                'is_followed_by_user' => false,
                'addressRelation' => [
                    'data' => [
                        'id' => 1,
                        'street' => 'Puttingstraat 8',
                        'zip' => '4564BJ',
                        'city' => 'Sint Jansteen',
                        'state' => 'Zeeland',
                        'country' => 'NL',
                        'latitude' => '51.2652937',
                        'longitude' => '4.0523321',
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    function it_can_show_a_company()
    {
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);

        $this->get('/api/companies/' . $company->slug())
            ->seeJsonEquals([
                'data' => $this->includedCompany($company),
            ]);
    }

    /** @test */
    function it_can_update_a_company()
    {
        $user = $this->loginAsUser();
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);
        $this->createCompanyUser([
            'user_id' => $user->id(),
            'company_id' => $company->id(),
            'is_admin' => true,
            'type' => TeamMember::TYPE,
        ]);

        $this->put('/api/companies/' . $company->slug(), [
            'name' => 'Update it',
            'telephone' => '85096',
            'website' => 'www.update.com',
            'email' => $company->email(),
            'street' => $address->street(),
            'zip' => $address->zip(),
            'city' => $address->city(),
            'state' => $address->state(),
            'country' => $address->country(),
        ])->seeJsonEquals([
            'data' => [
                'id' => $company->id(),
                'name' => 'Update it',
                'slug' => $company->slug(),
                'website' => 'http://www.update.com',
                'telephone' => '85096',
                'about' => $company->about(),
                'email' => $company->email(),
                'is_followed_by_user' => true,
                'addressRelation' => [
                    'data' => $this->includedAddress($company->address(), [
                        'id' => 2,
                        'latitude' => '44.4495134',
                        'longitude' => '-102.0783189',
                    ]),
                ]
            ]
        ]);
    }

    /** @test */
    function it_can_delete_a_company()
    {
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);

        $this->seeInDatabase(Company::TABLE, [
            'id' => $company->id(),
        ]);

        $this->delete('/api/companies/' . $company->slug())
            ->assertResponseStatus(204);

        $this->missingFromDatabase(Company::TABLE, [
            'id' => $company->id(),
        ]);
    }
}
