<?php
namespace functional\Api\Companies;

use EQM\Models\Companies\Stable;

class CompaniesTest extends \TestCase
{
    /** @test */
    function it_can_create_a_company()
    {
        $user = $this->loginAsUser();

        $this->post('/api/companies', [
            'name' => 'Test Company',
            'telephone' => '12345',
            'website' => 'www.test.com',
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
}
