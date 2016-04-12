<?php
namespace functional\Api\Companies;

use EQM\Core\Testing\DefaultIncludes;
use EQM\Models\Companies\Company;
use EQM\Models\Companies\Stable;

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
        $address = $this->createAddress();
        $company = $this->createCompany([
            'address_id' => $address->id(),
        ]);

        $this->put('/api/companies/' . $company->slug(), [
            'name' => 'Update it',
            'telephone' => '85096',
            'website' => 'www.update.com',
        ])->seeJsonEquals([
            'data' => $this->includedCompany($company, [
                'name' => 'Update it',
                'telephone' => '85096',
                'website' => 'http://www.update.com',
            ])
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
